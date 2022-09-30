<?php

namespace App\Application\Project\AdminBundle\Controller;

use App\Application\Project\AdminBundle\Attributes\AuthRouterRegister;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sonata\AdminBundle\Controller\CRUDController;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CRUDBaseController extends CRUDController
{

    public function listAction(Request $request): Response
    {
        return parent::listAction($request);
    }

    public function showAction(Request $request): Response
    {
        return parent::showAction($request);
    }

    public function createAction(Request $request): Response
    {
        return parent::createAction($request);
    }

    public function editAction(Request $request): Response
    {
        return parent::editAction($request);
    }

    public function deleteAction(Request $request): Response
    {
        return parent::deleteAction($request);
    }

    public function batchActionDelete(ProxyQueryInterface $query): Response
    {
        return parent::batchActionDelete($query);
    }

    public function batchAction(Request $request): Response
    {
        return parent::batchAction($request);
    }

    public function exportAction(Request $request): Response
    {
        return parent::exportAction($request);
    }

    public function historyAction(Request $request): Response
    {
        return parent::historyAction($request);
    }


    public function historyViewRevisionAction(Request $request, string $revision): Response
    {
        return parent::historyViewRevisionAction($request, $revision);
    }


    public function historyCompareRevisionsAction(Request $request, string $baseRevision, string $compareRevision): Response
    {
        return parent::historyCompareRevisionsAction($request, $baseRevision, $compareRevision);
    }























}