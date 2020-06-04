<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Tag;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
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
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     * @Route("/product/add", name="add_product")
     */
    public function addProduct(EntityManagerInterface $objectManager, Request $request) {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product); // => App\Form\ProductType
        $form->add('submit', SubmitType::class, [
            'label' => "Ajouter votre produit"
        ]);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $product->setUser($user);
            $product->setRef(substr(str_shuffle(md5(random_int(0, 1000000))), 0, 25));
            $objectManager->persist($product);
            $objectManager->flush();
            return $this->redirectToRoute('profile');
        }
        return $this->render('product/product-form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/product/tag/{slug}", name="products_by_tag")
     */
    public function productsByTag(Tag $tag/*, ProductRepository $productRepository*/) {
        // SELECT * FROM products
        // RIGHT JOIN product_tag ON product_tag.product_id = products.id
        // WHERE product_tag.tag_id = :tag_id
//        $products = $productRepository->findByTag($tag);

        return $this->render('product/products_by_tag.html.twig', [
            'tag' => $tag,
//            'products' => $products
        ]);
    }
}
