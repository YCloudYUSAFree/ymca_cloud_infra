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
      'openy_demo_nbranch' => ['openy_demo_node_branch'],
      // Locations page dependencies.
      'openy_prgf_loc_finder' => [],
      'openy_prgf_location_by_amenities' => [],
      'openy_demo_tamenities' => ['openy_demo_taxonomy_term_amenities'],
      'openy_demo_nlanding' => ['openy_demo_node_landing'],
    ];
    $this->moduleInstaller = $module_installer;
    $this->importer = $importer;
  }

  /**
   * Enable modules with demo content.
   */
  public function enableDemoContentModules() {
    foreach ($this->mapping as $module => $value) {
      $this->moduleInstaller->install([$module]);
    }
  }

  /**
   * Disable modules with demo content.
   */
  public function disableDemoContentModules() {
    foreach ($this->mapping as $module => $value) {
      $this->moduleInstaller->uninstall([$module]);
    }
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

}
