<?php
/**
 * phpwebsocket
 *
 * Quick hack to implement websockets in php.
 * As of Feb/10 the only browsers that support websockets are Google Chrome and Webkit Nightlies.
 * Get it from here http://www.google.com/chrome+
 * @author georgenava
 * @version 0.5
 * @copyright Copyright (c) 2010 georgenava
 */

// Usage: $master=new WebSocket('localhost',12345);
/**
 * WebSocket class for php.
 * Flash-policy-hack included by SourceR
 */
class WebSocket{
        /**
         * Flash-policy-request from flashplayer/flashplugin
         * @access public
         * @final
         * @var string
         */
        const     FLASH_POLICY_REQUEST   = "<policy-file-request/>\0";
        /**
         * Flash-policy-response for flashplayer/flashplugin
         * @access protected
         * @var string
         */
        protected $FLASH_POLICY_FILE     = "<cross-domain-policy><allow-access-from domain=\"*\" to-ports=\"*\" /></cross-domain-policy>\0";
        /**
         * Contains the master-socket
         * @access protected
         * @var ressource
         */
        protected $master;
        /**
         * Contains all active WebSockets
         * @access protected
         * @var array
         */
        protected $sockets = array();
        /**
         * Contains all Users
         * @access protected
         * @var array
         */
        protected $users   = array();
        /**
         * Set Debugmode on or off
         * @access public
         * @var boolean
         */
        public    $debug   = false;

        /**
         * Constructor for WebSocket-Class
         * @param string $address sets up the address for the socket-listener
         * @param int $port The port which will be listen
         * @return WebSocket $this an instance of WebSocket (should never return)
         */
        public function __construct($address,$port){
                $this->FLASH_POLICY_FILE = str_replace('to-ports="*','to-ports="'.$port,$this->FLASH_POLICY_FILE);
                error_reporting(E_ALL);
                set_time_limit(0);
                ob_implicit_flush();

                $this->master=socket_create(AF_INET, SOCK_STREAM, SOL_TCP)     or die('socket_create() failed');
                socket_set_option($this->master, SOL_SOCKET, SO_REUSEADDR, 1)  or die('socket_option() failed');
                socket_bind($this->master, $address, $port)                    or die('socket_bind() failed');
                socket_listen($this->master,20)                                or die('socket_listen() failed');
                $this->sockets[] = $this->master;
                self::say('Server Started : '.date('Y-m-d H:i:s'));
                self::say('Listening on   : '.$address.' port '.$port);
                self::say('Master socket  : '.$this->master.PHP_EOL);

                while(true){
                        $changed = $this->sockets;
                        socket_select($changed,$write=NULL,$except=NULL,NULL);
                        foreach($changed as $socket){
                                if($socket==$this->master){
                                        $client=socket_accept($this->master);
                                        if($client<0){
                                                self::log('socket_accept() failed'); continue;
                                        }else $this->connect($client);
                                }else{
                                        $bytes = @socket_recv($socket,$buffer,2048,0);
                                        if($buffer==WebSocket::FLASH_POLICY_REQUEST){
                                                self::log('FLASH_POLICY_REQUEST');
                                                socket_write($socket,$this->FLASH_POLICY_FILE,strlen($this->FLASH_POLICY_FILE));
                                        }elseif($bytes==0){
                                                $this->disconnect($socket);
                                        }else{
                                                $user = $this->getuserbysocket($socket);
                                                if(!$user->handshake)$this->dohandshake($user,$buffer);
                                                else $this->process($user,self::unwrap($buffer));
                                        }
                                }
                        }
                }
        }

        /**
         * Runns on userinput
         * @access protected
         * @param user $user The user who send the message
         * @param string $msg Recived messege
         */
        public function process($user,$msg){
                /* Extend and modify this method to suit your needs */
                /* Basic usage is to echo incoming messages back to client */
                $this->send($user->socket,$msg);
        }
        /**
         *      Sending a message to client
         * @final
         * @access protected
         * @param ressource $client Socket for writing
         * @param string $msg Message to send
         */
        final protected function send($client,$msg){
                self::say('> '.$msg);
                $msg = self::wrap($msg);
                socket_write($client,$msg,strlen($msg));
        }
        /**
         * Connecting a socket and create a new user instance
         * @final
         * @access protected
         * @param ressource $socket Socket to connect
         */
        final protected function connect($socket){
                $user = new User();
                $user->id = uniqid();
                $user->socket = $socket;
                array_push($this->users,$user);
                array_push($this->sockets,$socket);
                self::log($socket.' CONNECTED!');
        }
        /**
         * Removes a user from stack
         * @final
         * @access protected
         * @param ressource $socket Socket to disconnect
         */
        final protected function disconnect($socket){
                $found=null;
                $n=count($this->users);
                for($i=0;$i<$n;++$i)
                        if($this->users[$i]->socket==$socket){
                                $found=$i;
                                break;
                        }
                if(!is_null($found))
                        array_splice($this->users,$found,1);
                $index=array_search($socket,$this->sockets);
                socket_close($socket);
                self::log($socket.' DISCONNECTED!');
                if($index>=0)
                        array_splice($this->sockets,$index,1);
        }
        /**
         * Make WebSocket-handshake with user
         * @final
         * @access protected
         * @param user $users User which recieve the handshake
         * @param string $buffer Header from client
         * @return true
         */
        final protected function dohandshake($user,$buffer){
                self::log('Requesting handshake: '.$buffer);
                list($resource,$host,$origin) = self::getheaders($buffer);
                $upgrade="HTTP/1.1 101 Web Socket Protocol Handshake\r\n".
                        "Upgrade: WebSocket\r\n".
                        "Connection: Upgrade\r\n".
                        'WebSocket-Origin: '.$origin."\r\n".
                        'WebSocket-Location: ws://'.$host.$resource."\r\n\r\n\0";
                socket_write($user->socket,$upgrade,strlen($upgrade));
                $user->handshake=true;
                self::log('Done handshaking: '.$upgrade);
                return true;
        }
        /**
         * Returns the user for a socket
         * @final
         * @access protected
         * @param ressource $socket Socket to identify a user
         * @return user|null User who was found
         */
        final protected function getuserbysocket($socket){
                $found=null;
                foreach($this->users as $user)if($user->socket==$socket)return $user;
        }
        /**
         * Writes a debugmessage on console
         * @final
         * @access protected
         * @param string $msg String to print in console
         */
        final protected function log($msg=''){
                if($this->debug)echo addslashes($msg).PHP_EOL;
        }

        /**
         * Generates header-information about a request
         * @final
         * @access protected
         * @static
         * @param string $req Clientrequest
         * @return array Array[Path, Host, Origin]
         */
        final protected static function getheaders($req){
                $r=$h=$o=null;
                if(preg_match('/GET (.*) HTTP/'    ,$req,$match))$r=$match[1];
                if(preg_match("/Host: (.*)\r\n/"   ,$req,$match))$h=$match[1];
                if(preg_match("/Origin: (.*)\r\n/" ,$req,$match))$o=$match[1];
                return array($r,$h,$o);
        }
        /**
         * Writes a message in console
         * @final
         * @access protected
         * @static
         * @param string $msg String to print in console
         */
        final protected static function say($msg=''){
                echo addslashes($msg).PHP_EOL;
        }
        /**
         * Wraps a string into WebSocket format
         * @final
         * @access protected
         * @static
         * @param string $msg Unwraped string
         */
        final protected static function wrap($msg=''){
                return chr(0).$msg.chr(255);
        }
        /**
         * Unwraps a WebSocket string
         * @final
         * @access protected
         * @static
         * @param string $msg Wraped string
         */
        final protected static function unwrap($msg=''){
                return substr($msg,1,strlen($msg)-2);
        }
}

class User{
        public $id;
        public $socket;
        public $handshake;
}
