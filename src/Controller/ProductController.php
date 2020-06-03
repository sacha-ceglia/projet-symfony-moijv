<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/product/{id<\d+>}", name="product")
     */
    public function detail( Product $product /* $id, ProductRepository $productRepo*/)
    {
        // /product/5
        // $id = $_GET['id'];
//        $id = $request->get('id');
        // SELECT * FROM product WHERE id = :id
//        $product = $productRepo->find($id);
        return $this->render('product/detail.html.twig', [
            'product' => $product,
        ]);
    }

    /**
     * @Route("/product/add", name="add_product", methods={'GET', 'POST'})
     */
    public function addProduct(EntityManagerInterface $objectManager) {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product); // => App\Form\ProductType
        $form->add('submit', SubmitType::class, [
            'label' => "Ajouter votre produit"
        ]);
        dump($form->isSubmitted());
        // dump($form->isValid());
        dump($product);
        if($form->isSubmitted() && $form->isValid()) {
            $objectManager->persist($product);
            $objectManager->flush();
        }
        return $this->render('product/product-form.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
