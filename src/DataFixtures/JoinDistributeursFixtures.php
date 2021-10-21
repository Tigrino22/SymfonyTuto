<?php
namespace App\DataFixtures;

use App\Entity\Distributeur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Reference;
use App\Entity\Produit;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class JoinDistributeursFixtures extends Fixture implements FixtureInterface, ContainerAwareInterface
{

    private $container;

    public function setContainer(?ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $em = $this->container->get('doctrine.orm.entity_manager');
        $repProduit = $em->getRepository(Produit::class);

        $desktop = new Distributeur;
        $desktop->setNom('Desktop');

        $logitech = new Distributeur;
        $logitech->setNom('Logitech');

        $hp = new Distributeur;
        $hp->setNom('HP');

        $epson = new Distributeur;
        $epson->setNom('Epson');

        $dell = new Distributeur;
        $dell->setNom('Dell');

        $acer = new Distributeur;
        $acer->setNom('Acer');

        // Les jointures
        $produit = $repProduit->findOneBy(array(
            'nom' => 'souris'
        ));
        $produit->addDistributeur($hp);
        $produit->addDistributeur($logitech);
        $manager->persist($produit);

        $produit = $repProduit->findOneBy(array(
            'nom' => 'ecrans'
        ));
        $produit->addDistributeur($hp);
        $produit->addDistributeur($dell);
        $manager->persist($produit);

        $produit = $repProduit->findOneBy(array(
            'nom' => 'claviers'
        ));
        $produit->addDistributeur($hp);
        $produit->addDistributeur($logitech);
        $manager->persist($produit);

        $produit = $repProduit->findOneBy(array(
            'nom' => 'ordinateurs'
        ));
        $produit->addDistributeur($hp);
        $produit->addDistributeur($dell);
        $produit->addDistributeur($acer);
        $manager->persist($produit);

        $produit = $repProduit->findOneBy(array(
            'nom' => 'cartouches encre'
        ));
        $produit->addDistributeur($epson);
        $manager->persist($produit);

        $produit = $repProduit->findOneBy(array(
            'nom' => 'imprimantes'
        ));
        $produit->addDistributeur($hp);
        $produit->addDistributeur($epson);
        $manager->persist($produit);
        

        $manager->flush();
    }


}
