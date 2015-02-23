<?php

/**
 * Class RB_Prestation
 *
 * Les prestations.
 */
class RB_Prestation extends RB_Section
{
	/** @const  String Le nom de la slug par défaut. */
	const SLUG_DEFAULT = 'prestation';
	
	/** @var string */
	public $admin_class = 'RB_Prestation_Admin'; // TODO générer ça automatiquement.
	
	/** @var RB_Prestation_Admin L'objet d'administration du post_type Prestation. */
	public $admin;

	/**
	 * Constructeur. Fais pas mal de choses!
	 *
	 * @access public
	 * @param null|RB_Loader $loader Le loader qui va être appelé pour les hooks.
	 */
	public function __construct( RB_Loader $loader )
	{
		parent::__construct( 'prestation', $loader ); // TODO: Change the autogenerated stub
	}

	/**
	 * Charge les dépendances du programme.
	 *
	 * Lorsqu'on crée une nouvelle
	 *
	 * @access public
	 * @see    RB::load_all_dependencies
	 */
	public function load_dependencies()
	{
		if ( $this->is_admin ) {
			/** @noinspection PhpIncludeInspection */
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-rb-'.$this->post_type.'-admin.php';
		}
	}
	
	/**
	 * Crée L'objet admin.
	 *
	 * Devra comprendre une variable nommée Args
	 *
	 * @return mixed
	 */
	public function creer_objet_admin()
	{
		// Définir la table d'arguments.
		$args = array(
			'version' => $this->get_version(),
			'styles' => array(
				array(
					'handle' => $this->slug . 'prestation_admin',
					'filepath' => 'css/rb-prestation-admin.css',
				)
			),
			'scripts' => array(
				// TODO ajouter des scripts si possible.
			),
			'metadatas' => array(
			
			),
			'metaboxes' => array(
				array(
					'id' => 'rb_prestation_infobox',
					'title' => 'Infos générales de la Prestation',
					'show_dashicon' => true,
					'callback' => 'info', // sera 'render_info_metabox'
					'screen' => 'prestation',
					'context' => 'normal',
					'priority' => 'high',
				)
			),
		);
		
		// Créer l'objet qui gère le panneau d'administration.
		return new $this->admin_class( $this->post_type, $args );
	}

	/**
	 * Définit les hooks du panneau d'administration.
	 *
	 * @access  protected
	 * @see     RB::define_all_admin_hooks
	 *
	 * @param   \RB_Loader $loader Un pointeur vers le loader.
	 */
	protected function define_extra_hooks(RB_Loader $loader)
	{
		
	}

	/* ################################ */
	/* DÉBUT DES FONCTIONS DE CALLBACKS */
	/* ################################ */

	public function create_post_type()
	{
		// Déclarer les labels du post-type.
		$labels = array(
			'name'                => _x( 'Prestations', 'Post Type General Name', '/langage' ),
			'singular_name'       => _x( 'Prestation', 'Post Type Singular Name', '/langage' ),
			'menu_name'           => __( 'Prestation', '/langage' ),
			'parent_item_colon'   => __( 'Faisant parti du Spectacle: ', '/langage' ),
			'all_items'           => __( 'Toutes les Prestations', '/langage' ),
			'view_item'           => __( 'Voir les infos de la Prestation', '/langage' ),
			'add_new_item'        => __( 'Ajouter une Prestation', '/langage' ),
			'add_new'             => __( 'Ajouter', '/langage' ),
			'edit_item'           => __( 'Éditer les infos de la Prestation', '/langage' ),
			'update_item'         => __( 'Mettre à jour les infos de la Prestation', '/langage' ),
			'search_items'        => __( 'Chercher une Prestation', '/langage' ),
			'not_found'           => __( 'Non-trouvé', '/langage' ),
			'not_found_in_trash'  => __( 'Non-trouvé dans la corbeille', '/langage' ),
		);

		// Déclarer les arguments du rewrite pour le post-type.
		$rewrite = array(
			'slug'                => 'prestation',
			'with_front'          => true,
			'pages'               => true,
			'feeds'               => true,
		);

		// Déclarer les arguments principaux du post-type.
		$args = array(
			'label'               => __( 'prestation', '/langage' ),
			'description'         => __( 'Une prestation.', '/langage' ),
			'labels'              => $labels,
			'supports'            => array( '' ),
			'taxonomies'          => array( '' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 25, // Sous les commentaires.
			'menu_icon'           => 'dashicons-tickets-alt', // Icône bin sympa
			'can_export'          => true, // Pour faire des backups.
			'has_archive'         => true, // Eh, why not?
			'exclude_from_search' => true, // On veut être capable de les rechercher.
			'publicly_queryable'  => true,
			'rewrite'             => $rewrite,
			'capability_type'     => 'post', // C'est pas vraiment un post.
		);

		// Enregistre le post-type à l'aide de la liste d'arguments.
		register_post_type( 'prestation', $args );
	}
}
