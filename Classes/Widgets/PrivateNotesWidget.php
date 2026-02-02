<?php
declare(strict_types=1);

namespace Dl\Benotes\Widget;

use Dl\Benotes\Domain\Repository\NoteRepository;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;
use TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder;

/**
 * Backend widget to render latest private notes for logged-in backend user.
 */
class PrivateNotesWidget
{
    public function __construct(
        protected NoteRepository $noteRepository,
        protected ModuleTemplateFactory $moduleTemplateFactory,
        protected UriBuilder $uriBuilderBackend
    ) {}

    public function render(?ServerRequestInterface $request = null): string
    {
        $userUid = (int)$GLOBALS['BE_USER']->user['uid'];
        $notes = $this->noteRepository->findLatestPrivateByUser($userUid, 10);

        $fluid = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Fluid\View\StandaloneView::class);
        $fluid->setTemplatePathAndFilename(\TYPO3\CMS\Core\Utility\GeneralUtility::getFileAbsFileName('EXT:benotes/Resources/Private/Templates/Dashboard/PrivateNotes.html'));
        $fluid->assign('notes', $notes);
        $fluid->assign('moduleName', 'benotes_note');

        return $fluid->render();
    }
}