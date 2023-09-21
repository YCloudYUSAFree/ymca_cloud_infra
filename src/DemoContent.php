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
      // 'openy_demo_nclass' => [],
      // 'openy_demo_nfacility' => [],
      // 'openy_demo_nprogram' => [
      //   'openy_demo_paragraph_category_listing',
      //   'openy_demo_paragraph_promo_card',
      //   'openy_demo_node_program',
      // ],
      'openy_demo_bamenities' => [],
      'openy_demo_nbranch' => ['openy_demo_node_branch'],
      // 'openy_demo_nsessions' => [
      //   'openy_demo_node_session_01',
      //   'openy_demo_node_session_02',
      //   'openy_demo_node_session_03',
      //   'openy_demo_node_session_04',
      //   'openy_demo_node_session_05',
      //   'openy_demo_node_session_06',
      //   'openy_demo_paragraph_session_time_01',
      //   'openy_demo_paragraph_session_time_02',
      //   'openy_demo_paragraph_session_time_03',
      //   'openy_demo_paragraph_session_time_04',
      // ],
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
