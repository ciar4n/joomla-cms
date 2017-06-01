<?php
/**
 * @package     Joomla.Installation
 * @subpackage  Controller
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Default controller class for the Joomla Installer.
 *
 * @since  3.1
 */
class InstallationControllerDefault extends JControllerBase
{
	/**
	 * Execute the controller.
	 *
	 * @return  boolean  True if controller finished execution.
	 *
	 * @since   3.1
	 */
	public function execute()
	{
		// Get the application
		/** @var InstallationApplicationWeb $app */
		$app = $this->getApplication();

		$defaultView = 'site';

		// If the app has already been installed, default to the remove view
		if (file_exists(JPATH_CONFIGURATION . '/configuration.php') && (filesize(JPATH_CONFIGURATION . '/configuration.php') > 10)
			&& file_exists(JPATH_INSTALLATION . '/index.php'))
		{
			$defaultView = 'remove';
		}

		// Are we allowed to proceed?
		$model = new InstallationModelSetup;

		$vName   = $this->getInput()->getWord('view', $defaultView);
		$vFormat = $app->getDocument()->getType();
		$lName   = $this->getInput()->getWord('layout', 'default');

		if (strcmp($vName, $defaultView) == 0)
		{
			$this->getInput()->set('view', $defaultView);
		}

		if (!$model->getPhpOptionsSufficient())
		{
			if ($vName !== 'preinstall')
			{
				$app->redirect('index.php?view=preinstall');
			}

			$vName = 'preinstall';
		}
		else
		{
			switch ($vName)
			{
				case 'languages':
				case 'defaultlanguage':
					$model        = new InstallationModelLanguages;
					$checkOptions = false;
					$options      = [];

					break;
				case 'summary':
					$model        = new InstallationModelSetup;
//					InstallationModelConfiguration;
					$checkOptions = true;
					$options      = $model->getOptions();

					break;
				case 'remove':
					$model        = new InstallationModelSetup;
//					InstallationModelConfiguration;
					$checkOptions = true;
					$options      = $model->getOptions();

					break;
				default:
					$model        = new InstallationModelSetup;
					$checkOptions = true;
					$options      = [];

					break;
			}

			if ($vName != $defaultView && ($checkOptions && empty($options)))
			{
				$app->redirect('index.php');
			}
		}

		// Register the layout paths for the view
		$paths = new SplPriorityQueue;
		$paths->insert(JPATH_INSTALLATION . '/view/' . $vName . '/tmpl', 'normal');

		$vClass = 'InstallationView' . ucfirst($vName) . ucfirst($vFormat);

		if (!class_exists($vClass))
		{
			$vClass = 'InstallationViewDefault';
		}

		/** @var JViewHtml $view */
		$view = new $vClass($model, $paths);
		$view->setLayout($lName);

		// Render our view and set it to the document.
		$app->getDocument()->setBuffer($view->render(), 'component');

		return true;
	}
}
