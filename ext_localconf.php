<?php
defined('TYPO3') or die();

	$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
   \TYPO3\CMS\Core\Imaging\IconRegistry::class
	);
	$iconRegistry->registerIcon(
		'benotes-note', // Icon-Identifier, e.g. tx-myext-action-preview
		\TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class,
		['source' => 'EXT:benotes/Resources/Public/Icons/tx_benotes_domain_model_notes.gif']
	);
	
call_user_func(function()
{
   $extensionKey = 'benotes';

   \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScript(
      $extensionKey,
      'setup',
      "@import 'EXT:benotes/Configuration/TypoScript/setup.typoscript'"
   );
   \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScript(
      $extensionKey,
      'constants',
      "@import 'EXT:benotes/Configuration/TypoScript/constants.typoscript'"
   );
});
$GLOBALS['TYPO3_CONF_VARS']['MAIL']['templateRootPaths']['700'] = 'EXT:benotes/Resources/Private/Templates/Email/';
$GLOBALS['TYPO3_CONF_VARS']['BE']['stylesheets']['benotes'] = 'EXT:benotes/Resources/Public/css/tx_benotes.css';

// --- add Widgets ---
if (!isset($GLOBALS['TYPO3_CONF_VARS']['BE']['widgets'])) {
    $GLOBALS['TYPO3_CONF_VARS']['BE']['widgets'] = [];
}

$GLOBALS['TYPO3_CONF_VARS']['BE']['widgets']['benotes_latest_public'] = [
    'provider' => \Dl\Benotes\Widget\PublicNotesWidget::class,
    'title' => 'LLL:EXT:benotes/Resources/Private/Language/locallang.xlf:widget.public.title',
    'description' => 'LLL:EXT:benotes/Resources/Private/Language/locallang.xlf:widget.public.description'
];

$GLOBALS['TYPO3_CONF_VARS']['BE']['widgets']['benotes_latest_private'] = [
    'provider' => \Dl\Benotes\Widget\PrivateNotesWidget::class,
    'title' => 'LLL:EXT:benotes/Resources/Private/Language/locallang.xlf:widget.private.title',
    'description' => 'LLL:EXT:benotes/Resources/Private/Language/locallang.xlf:widget.private.description'
];
?>
