<?php

/*
 * This file is part of the Kimai time-tracking app.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Reporting;

use App\Form\Type\ReportSumType;
use App\Form\Type\YearPickerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class YearlyUserListForm extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('date', YearPickerType::class, [
            'model_timezone' => $options['timezone'],
            'view_timezone' => $options['timezone'],
            'start_date' => $options['start_date'],
            'show_range' => true,
        ]);
        $builder->add('sumType', ReportSumType::class);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => YearlyUserList::class,
            'timezone' => date_default_timezone_get(),
            'start_date' => new \DateTime(),
            'csrf_protection' => false,
            'method' => 'GET',
        ]);
    }
}
