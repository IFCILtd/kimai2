<?php

/*
 * This file is part of the Kimai time-tracking app.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Reporting;

use App\Form\Type\MonthPickerType;
use App\Form\Type\ReportSumType;
use App\Form\Type\UserType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MonthByUserForm extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('date', MonthPickerType::class, [
            'model_timezone' => $options['timezone'],
            'view_timezone' => $options['timezone'],
            'start_date' => $options['start_date'],
        ]);

        if ($options['include_user']) {
            $builder->add('user', UserType::class, ['width' => false]);
        }
        $builder->add('sumType', ReportSumType::class);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MonthByUser::class,
            'timezone' => date_default_timezone_get(),
            'start_date' => new \DateTime(),
            'include_user' => false,
            'csrf_protection' => false,
            'method' => 'GET',
        ]);
    }
}
