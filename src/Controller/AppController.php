<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     */
    public function index()
    {
        return $this->render('app/index.html.twig');
    }

    public function listSkills(EntityManagerInterface $manager)
    {
        $skills = $manager->getRepository('App\Entity\Skill')->loadAll();

        return $this->render('app/skills.html.twig', ["skills" => $skills]);
    }
}
