<?php

namespace App\Controller;

use App\Entity\RmRss;
use App\Repository\RmRssRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use NewsdataIO\NewsdataApi;


/**
 * @Route("/rss", name="rss_")
 */
class RssController extends AbstractController
{

    private EntityManagerInterface $em;
    private RmRssRepository $rssRepo;
    private NewsdataApi $newsDataApi;

//if i was using any other services i could have had private Service $svc so I wouldn need to assign in the function (PHP8 feature)
    public function __construct(EntityManagerInterface $em)
    {
      $this->em = $em;
      $this->rssRepo = $em->getRepository(RmRss::class);
      //need api key here to get the api to work.....would be in .env file which cannot be commited to keep keys safe

      $this->newsDataApi  = new NewsdataApi();
    }

    /**
     * @Route("/download", name="download")
     */
    public function downloadRssDataFromSource(Request $request)
    {
      //if this rss api did not have a php lib then i would have used a http client such as guzzle
      $data = ["q" => "world cup", "country" => "ie"];
      try {
        $response = $this->newsDataApi->get_latest_news($data);

        foreach ($response->results as $result) {
          $RmRss = new RmRss();
          $RmRss->setTitle($result->title);
          $RmRss->setDescription($result->description);
          $RmRss->setContent($result->content);
          $RmRss->setContentLink($result->link);
          $RmRss->setPubDate($result->pubDate);
          $this->em->persist($RmRss);
        }

        $this->em->flush();
      } catch(Exception $e) {
        //throw error to user
      }

      
    //I would add a flashbag succes message here
      return $this->redirectToRoute('rss_list');
           
    }


    /**
     * @Route("/list", name="list")
     */
    public function listRssFeeds(Request $request): Response
    {
      $rssList = $this->rssRepo->findAll();

      return $this->render('rss/list.html.twig', [
        'rssList' => $rssList
      ]);
    }

    /**
     * @Route("/{rmRssId}/view", name="view")
     */
    public function viewRssFeed(Request $request,RmRss $rmRss): Response
    {
      return $this->render('rss/view.html.twig', [
        'rmRss' => $rmRss
      ]);
    }
 
}
