<?php

declare(strict_types=1);

/*
 * This file is part of the package evoweb/sessionplaner.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Evoweb\Sessionplaner\Controller;

use Evoweb\Sessionplaner\Domain\Repository\DayRepository;
use Evoweb\Sessionplaner\Domain\Repository\SessionRepository;
use Evoweb\Sessionplaner\Enum\SessionLevelEnum;
use Evoweb\Sessionplaner\Enum\SessionTypeEnum;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Http\HtmlResponse;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

class BackendModuleController extends ActionController
{
    protected DayRepository $dayRepository;

    protected SessionRepository $sessionRepository;

    public function __construct(DayRepository $dayRepository, SessionRepository $sessionRepository)
    {
        $this->dayRepository = $dayRepository;
        $this->sessionRepository = $sessionRepository;
    }

    protected function initializeAction()
    {
        /** @var PageRenderer $pageRenderer */
        $pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
        $pageRenderer->loadRequireJsModule(
            'TYPO3/CMS/Sessionplaner/Edit',
            'function(sessionplaner) {
                sessionplaner.setPageId(' . (int)GeneralUtility::_GP('id') . ');
            }'
        );
    }

    public function showAction(): ResponseInterface
    {
        if ($this->request->hasArgument('day')) {
            $day = $this->dayRepository->findByUid($this->request->getArgument('day'));
        } else {
            /** @var \Evoweb\Sessionplaner\Domain\Model\Day $day */
            $day = $this->dayRepository->findAll()->getFirst();
        }

        $typeFieldOptions = SessionTypeEnum::getOptions();
        foreach ($typeFieldOptions as $typeFieldOptionKey => $typeFieldOptionValue) {
            $typeFieldOptions[$typeFieldOptionKey] = LocalizationUtility::translate($typeFieldOptionValue);
        }
        $levelFieldOptions = SessionLevelEnum::getOptions();
        foreach ($levelFieldOptions as $levelFieldOptionKey => $levelFieldOptionValue) {
            $levelFieldOptions[$levelFieldOptionKey] = LocalizationUtility::translate($levelFieldOptionValue);
        }

        $this->view->assign('formOptions', [
            'types' => $typeFieldOptions,
            'levels' => $levelFieldOptions,
        ]);
        $this->view->assign('currentDay', $day);
        $this->view->assign('roomCount', is_object($day) ? count($day->getRooms()) : 0);
        $this->view->assign('days', $this->dayRepository->findAll());
        $this->view->assign('unassignedSessions', $this->sessionRepository->findUnassignedSessions());

        return new HtmlResponse($this->view->render());
    }

    /**
     * Disable error flash message
     *
     * @return bool
     */
    protected function getErrorFlashMessage()
    {
        return false;
    }
}
