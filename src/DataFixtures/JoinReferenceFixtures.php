<?php
namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use App\Entity\Reference;
use App\Entity\Produit;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class JoinReferenceFixtures extends Fixture implements FixtureInterface, ContainerAwareInterface
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
        $repProduits = $em->getRepository(Produit::class);
        $listeProduits = $repProduits->findAll();


        foreach ($listeProduits as $monProduit) {
            
            $reference = new Reference;

            $reference->setNumero(rand());

            $monProduit->setReference($reference);
            $manager->persist($monProduit);
        }

        $manager->flush();
    }


}
