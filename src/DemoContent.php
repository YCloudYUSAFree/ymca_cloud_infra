<?php

namespace Drupal\ymca_cloud_infra;

use Drupal\Core\Extension\ModuleInstallerInterface;
use Drupal\openy_migrate\Importer;

/**
 * Service description.
 */
class DemoContent {

  /**
   * The mapping array.
   *
   * @var array
   */
  protected $mapping;

  /**
   * The module installer.
   *
   * @var \Drupal\Core\Extension\ModuleInstaller
   */
  protected $moduleInstaller;

  /**
   * The importer.
   *
   * @var \Drupal\openy_migrate\Importer
   */
  protected $importer;

  /**
   * Class constructor.
   */
  public function __construct(ModuleInstallerInterface $module_installer, Importer $importer) {
    $this->mapping = [
      // Demo branches content.
      'openy_demo_nbranch' => ['openy_demo_node_branch'],
      // Locations page dependencies.
      'openy_prgf_loc_finder' => [],
      'openy_prgf_location_by_amenities' => [],
      'openy_demo_tamenities' => ['openy_demo_taxonomy_term_amenities'],
      'openy_demo_nlanding' => ['openy_demo_node_landing'],
      // Programs sub-program content.
      'openy_prgf_categories_listing' => [],
      'openy_prgf_classes_listing' => [],
      'openy_prgf_branches_popup_all' => [],
      'openy_demo_nprogram' => [
        'openy_demo_paragraph_category_listing',
        'openy_demo_paragraph_promo_card',
        'openy_demo_node_program',
      ],
      'openy_demo_ncategory' => ['openy_demo_node_program_subcategory'],
      'openy_demo_nclass' => [
        'openy_demo_node_activity',
        'openy_demo_node_class_01',
        'openy_demo_node_class_02',
        'openy_demo_paragraph_branches_popup_class_01',
        'openy_demo_paragraph_branches_popup_class_02',
        'openy_demo_paragraph_class_location_01',
        'openy_demo_paragraph_class_location_02',
        'openy_demo_paragraph_class_sessions_01',
        'openy_demo_paragraph_class_sessions_02',
      ],
      'openy_demo_menu' => [],
      'openy_demo_menu_main' => [],
      'ymca_cloud_infra_main_menu_demo' => ['yusa_demo_menu_link_main'],
    ];
    $this->moduleInstaller = $module_installer;
    $this->importer = $importer;
  }

  /**
   * Enable modules with demo content.
   */
  public function enableDemoContentModules() {
    $modules = array_keys($this->mapping) ?? [];
    $this->moduleInstaller->install($modules);
  }

  /**
   * Disable modules with demo content.
   */
  public function disableDemoContentModules() {
    $modules = array_keys($this->mapping) ?? [];
    // Disable only demo content modules.
    $modules = array_filter($modules, function ($module) {
      return strpos($module, 'demo') !== FALSE;
    });
    $this->moduleInstaller->uninstall($modules);
  }

  /**
   * Run migrations.
   */
  public function runMigrations() {
    foreach ($this->mapping as $migration_ids) {
      foreach ($migration_ids as $migration_id) {
        $this->importer->import($migration_id);
      }
    }
  }

  /**
   * Clear main menu. Remove all items.
   */
  public function clearMainMenu() {
    $menu_tree = \Drupal::menuTree();
    $parameters = $menu_tree->getCurrentRouteMenuTreeParameters('main');
    $tree = $menu_tree->load('main', $parameters);
    foreach ($tree as $item) {
      $item->link->deleteLink();
    }
  }

}
