<?php

namespace GeniusDesign\BackendBundle\Controller;

use GeniusDesign\CommonBundle\Controller\MainController;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use GeniusDesign\Components\GalleryBundle\Form\ImageType;
use GeniusDesign\Components\GalleryBundle\Form\GalleryType;
use GeniusDesign\Components\GalleryBundle\Entity\Gallery;
use GeniusDesign\Components\GalleryBundle\Entity\Image;

/**
 * Gallery mangament
 * 
 * @author Paweł Cichoń <cichonpawelhd@gmail.com>
 * @copyright GeniusDesign
 */
class GalleryController extends MainController {

    /**
     * Displays gallery list
     * @return Response
     */
    public function listAction() {
        $languageLcid = $this->getLanguageLcid();

        $repository = $this->getDoctrine()
                ->getEntityManager()
                ->getRepository('GeniusDesignComponentsGalleryBundle:Gallery')
                ->setLanguageLcid($languageLcid);

        $galleries = $repository->getGalleries();

        $parameters = array(
            'galleries' => $galleries,
            'languageCode' => $this->getLanguageCode(),
        );

        return $this->render('GeniusDesignBackendBundle:Gallery:list.html.twig', $parameters);
    }

    /**
     * Displays one gallery
     * @return Response
     */
    public function editAction($gallerySlug) {
        return $this->commonForAddAndEdit($gallerySlug);
    }

    /**
     * Adds gallery
     * @return Response
     */
    public function addAction() {
        $gallerySlug = 0;
        return $this->commonForAddAndEdit($gallerySlug);
    }

    /**
     * Common method for add and edit
     * @return Response
     */
    public function commonForAddAndEdit($gallerySlug) {
        $galleryHelper = $this->get('genius_design_gallery.helper');
        $isGalleryDescriptionEnabled = $galleryHelper->isGalleryDescriptionEnabled();
        
        $entityManager = $this->getDoctrine()->getEntityManager();
        $gallery = null;
        $isAddsGallery = false;
        $request = $this->getRequest();
        $languageLcid = $this->getLanguageLcid();

        if (empty($gallerySlug)) {
            $gallerySlug = 0;
        }

        if ($gallerySlug === 0) {
            $gallery = new Gallery();
            $isAddsGallery = true;
        } else {
            $repository = $entityManager->getRepository('GeniusDesignComponentsGalleryBundle:Gallery')
                    ->setLanguageLcid($languageLcid);
            $gallery = $repository->getGalleryBySlug($gallerySlug);
        }

        if ($gallery === null) {
            return $this->redirectTo();
        }

        $form = $this->createForm(new GalleryType($isGalleryDescriptionEnabled), $gallery);

        if (strtolower($request->getMethod()) == 'post') {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $gallery->setTranslatableLocale($languageLcid)
                        ->setOriginalTitle($gallery->getTitle());

                $entityManager->persist($gallery);
                $entityManager->flush();

                $this->addFlashMessage('notice', 'Zapisałem');
                return $this->redirectTo();
            }

            $this->addFlashMessage('error', 'Nie zapisałem');
        }

        $parameters = array(
            'form' => $form->createView(),
            'gallery' => $gallery,
            'languageCode' => $this->getLanguageCode(),
            'isAddsGallery' => $isAddsGallery
        );
        return $this->render('GeniusDesignBackendBundle:Gallery:add-edit-gallery.html.twig', $parameters);
    }

    /**
     * Displays one gallery images
     * @return Response
     */
    public function imagesAction($gallerySlug) {
        $imageId = 0;
        return $this->commonImagesDisplayAndEdit($gallerySlug, $imageId);
    }

    /**
     * Edit one gallery image
     * @return Response
     */
    public function imageEditAction($gallerySlug, $imageId) {
        return $this->commonImagesDisplayAndEdit($gallerySlug, $imageId);
    }

    /**
     * Common for images
     * @return Response
     */
    public function commonImagesDisplayAndEdit($gallerySlug, $imageId) {
        $galleryHelper = $this->get('genius_design_gallery.helper');
        $isGalleryDescriptionEnabled = $galleryHelper->isGalleryDescriptionEnabled();
        $isImageAutorEnabled = $galleryHelper->isImageAutorEnabled();
        
        $isEditImage = false;
        $request = $this->getRequest();
        $entityManager = $this->getDoctrine()->getEntityManager();
        $languageLcid = $this->getLanguageLcid();

        $repository = $entityManager->getRepository('GeniusDesignComponentsGalleryBundle:Gallery')
                ->setLanguageLcid($languageLcid);

        $gallery = $repository->getGalleryBySlug($gallerySlug);

        if ($gallery === null) {
            return $this->redirectTo();
        }

        $imageId = (int) $imageId;

        if ($imageId === 0) {
            $image = new Image();
        } else {
            $repository = $entityManager->getRepository('GeniusDesignComponentsGalleryBundle:Image')
                    ->setLanguageLcid($languageLcid);
            $image = $repository->getRow($imageId);
            $isEditImage = true;
        }

        if ($image === null) {
            return $this->redirectTo('genius_gallery_images', array('gallerySlug' => $gallerySlug));
        }

        $form = $this->createForm(new ImageType($isImageAutorEnabled, !$isEditImage), $image);

        if (strtolower($request->getMethod()) == 'post') {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $uploadHelper = $this->get('genius_design_upload.helper');
                $image->setUploadHelper($uploadHelper)
                        ->setTranslatableLocale($languageLcid)
                        ->setGallery($gallery);

                $entityManager->persist($image);
                $entityManager->flush();

                $this->addFlashMessage('notice', 'Zapisałem');
                return $this->redirectTo('genius_gallery_images', array('gallerySlug' => $gallerySlug));
            }

            $this->addFlashMessage('error', 'Nie zapisałem');
        }

        $parameters = array(
            'form' => $form->createView(),
            'gallery' => $gallery,
            'image' => $image,
            'languageCode' => $this->getLanguageCode(),
            'isEditImage' => $isEditImage,
            'isGalleryDescriptionEnabled' => $isGalleryDescriptionEnabled,
            'isImageAutorEnabled' => $isImageAutorEnabled
        );
        return $this->render('GeniusDesignBackendBundle:Gallery:add-edit-images.html.twig', $parameters);
    }

    /**
     * Deletes gallery image
     * @return Response
     */
    public function imageDeleteAction($gallerySlug, $imageId) {
        $type = 'error';
        $message = 'Nie usunąłem';

        $imageId = (int) $imageId;

        if ($imageId > 0) {
            $repository = $this->getDoctrine()
                    ->getEntityManager()
                    ->getRepository('GeniusDesignComponentsGalleryBundle:Image');

            $image = $repository->getRow($imageId);

            if (!empty($image)) {
                $imageFileName = $image->getImageFileName();

                if (!empty($imageFileName)) {
                    $entityConfigName = 'genius_design_components_gallery';
                    $this->get('genius_design_upload.helper')->removeFile($entityConfigName, $imageFileName, true, false);
                }

                $repository->deleteImageById($image->getId());
                $type = 'notice';
                $message = 'Usunąłem';
            }
        }

        $this->addFlashMessage($type, $message);
        return $this->redirectTo('genius_gallery_images', array('gallerySlug' => $gallerySlug));
    }

    /**
     * Deletes gallery
     * @return Response
     */
    public function galleryDeleteAction($gallerySlug) {
        $type = 'error';
        $message = 'Nie usunąłem';

        if (!empty($gallerySlug)) {
            $repository = $this->getDoctrine()
                    ->getEntityManager()
                    ->getRepository('GeniusDesignComponentsGalleryBundle:Gallery');

            $gallery = $repository->getGalleryBySlug($gallerySlug);

            if (!empty($gallery)) {
                $images = $gallery->getImages();

                if (!empty($images)) {
                    foreach($images as $image) {
                        $imageFileName = $image->getImageFileName();
                        
                        if (!empty($imageFileName)) {
                            $entityConfigName = 'genius_design_components_gallery';
                            $this->get('genius_design_upload.helper')->removeFile($entityConfigName, $imageFileName, true, false);
                        }
                    }
                }

                $repository->deleteGalleryBySlug($gallerySlug);
                $type = 'notice';
                $message = 'Usunąłem';
            }
        }

        $this->addFlashMessage($type, $message);
        return $this->redirectTo();
    }

    /**
     * Redirects to the route
     * 
     * @param [string $route = ''] The name of the route
     * @param [array $parameters = array()] An array of parameters
     * @return Reponse
     */
    public function redirectTo($route = '', $parameters = array()) {
        if (empty($route)) {
            $route = 'genius_gallery_list';
        }

        $parameters = array_merge($parameters, array('languageCode' => $this->getLanguageCode()));
        return parent::redirectTo($route, $parameters);
    }

}
