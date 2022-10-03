<?php

namespace App\Application\Project\ContentBundle\Controller;

use App\Application\Project\ContentBundle\Attributes\ARR;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sonata\AdminBundle\Controller\CRUDController;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultCRUDController extends CRUDController
{
    protected string $listAction = "";
    protected string $showAction = "";
    protected string $createAction = "";
    protected string $editAction = "";
    protected string $deleteAction = "";
    protected string $batchAction = "";
    protected string $exportAction = "";
    protected string $historyAction = "";

    public function listAction(Request $request): Response
    {
        /** Access Control Validate */
        if($this->listAction)
            $this->denyAccessUnlessGranted($this->listAction);

        return parent::listAction($request);
    }

    public function showAction(Request $request): Response
    {
        /** Access Control Validate */
        if($this->showAction)
            $this->denyAccessUnlessGranted($this->showAction);

        return parent::showAction($request);
    }

    public function createAction(Request $request): Response
    {
        /** Access Control Validate */
        $this->validateAccess($this->createAction);

        return parent::createAction($request);
    }

    public function editAction(Request $request): Response
    {
        /** Access Control Validate */
        if($this->editAction)
            $this->denyAccessUnlessGranted($this->editAction);

        return parent::editAction($request);
    }

    public function deleteAction(Request $request): Response
    {
        /** Access Control Validate */
        if($this->deleteAction)
            $this->denyAccessUnlessGranted($this->deleteAction);

        return parent::deleteAction($request);
    }

    public function batchActionDelete(ProxyQueryInterface $query): Response
    {
        /** Access Control Validate */
        if($this->batchAction)
            $this->denyAccessUnlessGranted($this->batchAction);

        return parent::batchActionDelete($query);
    }

    public function batchAction(Request $request): Response
    {
        /** Access Control Validate */
        if($this->batchAction)
            $this->denyAccessUnlessGranted($this->batchAction);

        return parent::batchAction($request);
    }

    public function exportAction(Request $request): Response
    {
        /** Access Control Validate */
        if($this->exportAction)
            $this->denyAccessUnlessGranted($this->exportAction);

        return parent::exportAction($request);
    }

    public function historyAction(Request $request): Response
    {
        /** Access Control Validate */
        if($this->historyAction)
            $this->denyAccessUnlessGranted($this->historyAction);

        return parent::historyAction($request);
    }

    public function historyViewRevisionAction(Request $request, string $revision): Response
    {
        /** Access Control Validate */
        if($this->historyAction)
            $this->denyAccessUnlessGranted($this->historyAction);

        return parent::historyViewRevisionAction($request, $revision);
    }

    public function historyCompareRevisionsAction(Request $request, string $baseRevision, string $compareRevision): Response
    {
        /** Access Control Validate */
        if($this->historyAction)
            $this->denyAccessUnlessGranted($this->historyAction);

        return parent::historyCompareRevisionsAction($request, $baseRevision, $compareRevision);
    }

    /**
     * Validate access as routes
     * @param string $role
     * @return void
     */
    public function validateAccess(string $role): void
    {
        if($this->isGranted("ROLE_SUPER_ADMIN"))
            return;

        if($role)
            $this->denyAccessUnlessGranted($role);
    }

}