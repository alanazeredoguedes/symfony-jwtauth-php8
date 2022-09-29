<?php

namespace App\Application\Project\AdminBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
use Sonata\AdminBundle\Datagrid\ProxyQueryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
class CRUDBaseController extends CRUDController
{

    /**
     * @param Request $request
     * @return Response
     */
    public function listAction(Request $request): Response
    {
        return parent::listAction($request);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function showAction(Request $request): Response
    {
        return parent::showAction($request);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function createAction(Request $request): Response
    {
        return parent::createAction($request);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function editAction(Request $request): Response
    {
        return parent::editAction($request);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function deleteAction(Request $request): Response
    {
        return parent::deleteAction($request);
    }

    /**
     * @param ProxyQueryInterface $query
     * @return Response
     */
    public function batchActionDelete(ProxyQueryInterface $query): Response
    {
        return parent::batchActionDelete($query);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function batchAction(Request $request): Response
    {
        return parent::batchAction($request);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function exportAction(Request $request): Response
    {
        return parent::exportAction($request);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function historyAction(Request $request): Response
    {
        return parent::historyAction($request);
    }

    /**
     * @param Request $request
     * @param string $revision
     * @return Response
     */
    public function historyViewRevisionAction(Request $request, string $revision): Response
    {
        return parent::historyViewRevisionAction($request, $revision);
    }

    /**
     * @param Request $request
     * @param string $baseRevision
     * @param string $compareRevision
     * @return Response
     */
    public function historyCompareRevisionsAction(Request $request, string $baseRevision, string $compareRevision): Response
    {
        return parent::historyCompareRevisionsAction($request, $baseRevision, $compareRevision);
    }























}