<?php

/*
 * This file is part of the Kimai time-tracking app.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Twig;

use App\Entity\User;
use App\Repository\BookmarkRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class DatatableExtensions extends AbstractExtension
{
    /**
     * @var array<string, array<string, array<string, string|bool>>>
     */
    private array $dataTables = [];

    public function __construct(private BookmarkRepository $bookmarkRepository)
    {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('initialize_datatable', [$this, 'initializeDatatable']),
            new TwigFunction('datatable_column_class', [$this, 'getDatatableColumnClass']),
        ];
    }

    public function initializeDatatable(User $user, string $dataTable, array $defaultColumns): array
    {
        if (!\array_key_exists($dataTable, $this->dataTables)) {
            $columns = [];
            foreach ($defaultColumns as $key => $settings) {
                $columns[$key] = [
                    'visible' => $this->checkInColumDefinition($defaultColumns, $key),
                    'class' => \array_key_exists($key, $defaultColumns) ? $this->getClass($settings) : ''
                ];
                // add an auto-generated class
                $columns[$key]['class'] .= ' col_' . $key;
            }

            $bookmark = $this->bookmarkRepository->findBookmark($user, 'datatable', $dataTable);
            if ($bookmark !== null) {
                $content = $bookmark->getContent();
                foreach ($content as $key => $value) {
                    if (!\array_key_exists($key, $columns)) {
                        $columns[$key] = [];
                    }
                    $columns[$key]['visible'] = (bool) $value;
                }

                // disable all columns, which were not bookmarked as visible
                foreach (array_diff(array_keys($columns), array_keys($content)) as $key) {
                    if (!str_contains($columns[$key]['class'], 'alwaysVisible')) {
                        $columns[$key]['visible'] = false;
                    }
                }

                // now make sure that all columns have proper classes - this might only be applied if a bookmark exists
                foreach (array_keys($columns) as $key) {
                    if ($columns[$key]['visible']) {
                        $columns[$key]['class'] = $this->makeVisible($columns[$key]['class']);
                    } else {
                        $columns[$key]['class'] = $this->makeHidden($columns[$key]['class']);
                    }
                }
            }

            $this->dataTables[$dataTable] = $columns;
        }

        return $this->dataTables[$dataTable];
    }

    public function getDatatableColumnClass(string $dataTable, string $column): string
    {
        if (!\array_key_exists($column, $this->dataTables[$dataTable])) {
            return '';
        }

        return $this->dataTables[$dataTable][$column]['class'];
    }

    private function checkInColumDefinition(array $columns, string $column): bool
    {
        if (!\array_key_exists($column, $columns)) {
            return false;
        }

        $tmp = $this->getClass($columns[$column]);

        if (str_contains($tmp, 'alwaysVisible')) {
            return true;
        }

        $result = true;
        if (stripos($tmp, 'd-none') !== false) {
            $result = false;
        }

        if (str_contains($tmp, '-table-cell')) {
            $result = true;
        }

        return $result;
    }

    private function makeVisible(string $class): string
    {
        $newClass = [];
        foreach (explode(' ', $class) as $class) {
            if (!str_contains($class, '-none')) {
                $newClass[] = $class;
            }
        }

        return implode(' ', $newClass);
    }

    private function makeHidden(string $class): string
    {
        $newClass = [];
        foreach (explode(' ', $class) as $class) {
            if (!str_contains($class, '-table-cell')) {
                $newClass[] = $class;
            }
        }

        $newClass = implode(' ', $newClass);

        if (!str_contains($newClass, '-none')) {
            $newClass .= ' d-none';
        }

        return $newClass;
    }

    private function getClass($class): string
    {
        if (\is_array($class)) {
            if (!\array_key_exists('class', $class)) {
                return '';
            }

            return $class['class'];
        }

        if (!\is_string($class)) {
            return '';
        }

        return $class;
    }
}
