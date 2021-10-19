<?php
namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Produit;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class UpdateImgProduitFixtures extends Fixture implements FixtureInterface, ContainerAwareInterface
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
        $listeProduits = $repProduit->findAll();

        foreach ($listeProduits as $monProduit) {
            
            switch ($monProduit->getNom()) {
                case 'imprimantes':
                    $monProduit->setLienImage("imprimante.jpeg");
                    break;
                case 'cartouches encre':
                    $monProduit->setLienImage("cartouches encre.jpeg");
                    break;
                case 'ordinateurs':
                    $monProduit->setLienImage("ordinateurs.jpeg");
                    break;
                case 'écrans':
                    $monProduit->setLienImage("ecran.jpeg");
                    break;
                case 'claviers':
                    $monProduit->setLienImage("clavier.jpeg");
                    break;
                case 'souris':
                    $monProduit->setLienImage("souris.jpeg");
                    break;
            }

            $manager->persist($monProduit);
        }

        $manager->flush();
    }


}
