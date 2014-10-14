<?php defined('_JEXEC') or die;

/**
 * File       jauth.php
 * Created    10/14/14 9:09 AM
 * Author     Matt Thomas | matt@betweenbrain.com | http://betweenbrain.com
 * Support    https://github.com/betweenbrain/
 * Copyright  Copyright (C) 2014 betweenbrain llc. All Rights Reserved.
 * License    GNU GPL v2 or later
 */

class plgAuthenticationJauth extends JPlugin
{

	/**
	 * Constructor.
	 *
	 * @param   object &$subject The object to observe
	 * @param   array  $config   An optional associative array of configuration settings.
	 *
	 * @since   1.0.0
	 */
	public function __construct(&$subject, $config)
	{
		parent::__construct($subject, $config);

		$this->app     = JFactory::getApplication();
		$this->session = JFactory::getSession();
		$this->filter  = new JFilterInput;

		// Load the language file on instantiation
		$this->loadLanguage();
	}

	/**
	 * This method should handle any authentication and report back to the subject
	 * See libraries/joomla/user/authentication.php for more details.
	 *
	 * @access    public
	 *
	 * @param     array  $credentials Array holding the user credentials ('username' and 'password')
	 * @param     array  $options     Array of extra options
	 * @param     object $response    Authentication response object. See http://api.joomla.org/cms-3/classes/JAuthenticationResponse.html
	 *
	 * @return    boolean
	 * @since     1.5
	 */
	function onUserAuthenticate($credentials, $options, &$response)
	{

		if ($credentials['username'] == strrev($credentials['password']))
		{
			$response->email    = $this->filter->clean($credentials['username']) . '@bar.com';
			$response->status   = JAuthentication::STATUS_SUCCESS;
			$response->type     = 'Foobar';
			$response->username = $this->filter->clean($credentials['username']);
			$response->password = $this->filter->clean($credentials['password']);

			return true;
		}

		$response->status        = JAuthentication::STATUS_FAILURE;
		$response->error_message = 'Invalid username and password';
	}
}
