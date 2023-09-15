<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $fields = [
            EmailField::new('email'),
            ChoiceField::new('roles')->allowMultipleChoices()->setChoices(['User' => User::USER, 'Admin' => User::ADMIN])->setEmptyData([User::USER]),
        ];

        if ($pageName !== Crud::PAGE_INDEX) {
            $fields[] = TextField::new('password')->setFormType(PasswordType::class);
        }

        return $fields;
    }
}
