<?php
namespace STS\Session;

class RawSessionHandler implements \SessionHandlerInterface {
	/**
	 * Reference to our session data
	 * @var array
	 */
	private $data;

	/**
	 * Create a new raw PHP session handler instance.
	 * 
	 * @param string $namespace Keep session data in a $_SESSION sub-array
	 */
	public function __construct($namespace = null) 
	{
		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}

		$this->setupNamespace($namespace);
	}

	/**
	 * If provided, we'll use a sub-array of $_SESSION instead of the 
	 * root array. This keeps us from polluting the root $_SESSION,
	 * which could be important if we're sharing session with other apps.
	 * 
	 * @param  string $namespace
	 * @return void
	 */
	private function setupNamespace($namespace) 
	{
		if(!is_null($namespace)) {
			if(!isset($_SESSION[$namespace]) || !is_array($_SESSION[$namespace])) {
				$_SESSION[$namespace] = array();
			}
			$this->data = &$_SESSION[$namespace];
		} else {
			$this->data = &$_SESSION;
		}
	}

	/**
	 * {@inheritDoc}
	 */
	public function open($savePath, $sessionName) 
	{
		return true;
	}

	/**
	 * {@inheritDoc}
	 */
	public function close() 
	{
		session_write_close();
		return true;
	}

	/**
	 * {@inheritDoc}
	 */
	public function read($sessionId) 
	{
		return serialize($this->data);
	}

	/**
	 * {@inheritDoc}
	 */
	public function write($sessionId, $data) 
	{
		$this->data = unserialize($data);
	}

	/**
	 * {@inheritDoc}
	 */
	public function destroy($sessionId) 
	{
		session_destroy();
		return true;
	}

	/**
	 * {@inheritDoc}
	 */
	public function gc($lifetime) 
	{
		return true;
	}

}