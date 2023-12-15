<?php

class Ex {

	protected $file_content;
	protected $page_id;
	protected $page_content;
	protected $page_content_clear;
	protected $page_option_search;

	public function __construct( int $page_id, string $page_option_search ) {
		if ( ! is_admin() ) {
			require 'vendor/autoload.php';

			$file        = 'xls/Katalog__na_sayt_2.xlsx';
			$file_type   = \PhpOffice\PhpSpreadsheet\IOFactory::identify( $file );
			$file_reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader( $file_type );
			$spreadsheet = $file_reader->load( $file );

			$this->file_content = $spreadsheet;
			$this->page_id      = $page_id;

			$this->page_content = $spreadsheet->getSheet( $this->page_id )->toArray();

			if ( ! $this->page_content ) {
				return;
			}

			$this->page_content_clear = $this->ex_clear_content();
			$this->page_option_search = $page_option_search;

		}
	}

	public function ex_get_header() {
		$header = array_values( $this->page_content[0] );

		return $header;
	}

	public function ex_get_header_index( string $title ) {
		return array_keys( $this->ex_get_header(), $title )[0];
	}

	public function ex_clear_content() {
		$return = [];
		foreach ( $this->page_content as $item ) {
			$return[] = $item;
		}
		if ( ! empty( $return ) ) {
			unset( $return[0] );
		}

		return $return;
	}

	public function ex_get_title_options() {
		$header_index = $this->ex_get_header_index( $this->page_option_search );
		$array        = [];

		foreach ( $this->ex_get_header() as $key => $item ) {
			if ( $key > $header_index ) {
				$array[] = $item;
			}
		}

		return $array;
	}

	public function ex_get_value_options() {
		$return       = $array = [];
		$header_index = $this->ex_get_header_index( $this->page_option_search );

		foreach ( $this->page_content_clear as $list_key => $list ) {
			foreach ( $list as $key => $item ) {
				if ( $key > $header_index ) {
					$array[ $list_key ][] = $item;
				}
			}
		}

		foreach ( $array as $item ) {
			$return[] = array_combine( $this->ex_get_title_options(), $item );
		}

		return $return;
	}

	public function ex_get_option( $id, $title ) {
		$item = $this->ex_get_value_options()[ $id ];
		if ( $item ) {
			return $item[ $title ];
		}

		return false;
	}

	public function ex_get_file( $title = 'Аккумулятор 1,5Ач 5120-Li-12-15 12V' ) {

		$title = trim( $title );
		$files = [];
		$path  = '';
		$url   = '<site>/images/';

		$dir     = '<local>\images/';
		$folders = scandir( $dir );
		array_shift( $files );
		array_shift( $files );

		foreach ( $folders as $folder ) {
			if ( strstr( $folder, $title ) ) {
				$files[] = $folder;
			}
		}

		if ( $files ) {
			foreach ( $files as $file ) {
				if ( ! empty( $file ) ) {
					$in = scandir( $dir . $file );
					array_shift( $in );
					array_shift( $in );
					$path = $url . $file . '/' . $in[0];
				}
			}
		}

		$image_id = $this->ex_remote_upload_attachments( $path, 1 );

		return $image_id;
	}

	public function ex_remote_upload_attachments( $image_url, $parent_id ) {
		$image = $image_url;

		$get = wp_remote_get( $image );
		$type = wp_remote_retrieve_header( $get, 'content-type' );

		if ( ! $type ) {
			return false;
		}

		$mirror = wp_upload_bits( basename( $image ), '', wp_remote_retrieve_body( $get ) );

		$attachment = array(
			'post_title'     => basename( $image ),
			'post_mime_type' => $type
		);
		$attach_id = wp_insert_attachment( $attachment, $mirror['file'], $parent_id );

		require_once( ABSPATH . 'wp-admin/includes/image.php' );

		$attach_data = wp_generate_attachment_metadata( $attach_id, $mirror['file'] );
		wp_update_attachment_metadata( $attach_id, $attach_data );

		return $attach_id;
	}

	public function ex_get_full_to_array( string $string = null ) {
		$string = explode( '●', $string );
		$array  = [];

		foreach ( $string as $item ) {
			if ( ! empty( $item ) ) {
				$array[] = trim( $item );
			}
		}

		return $array;
	}

	public function ex_get_content() {
		$new_array = [];
		foreach ( $this->page_content_clear as $key => $item ) {
			if ( ! empty( $item[ $this->ex_get_header_index( 'Наименование' ) ] ) ) {
				$full_content = $item[ $this->ex_get_header_index( 'Полное описание' ) ];

				$new_array[] = [
					'title'      => $item[ $this->ex_get_header_index( 'Наименование' ) ],
					'articul'    => $item[ $this->ex_get_header_index( 'Артикул' ) ],
					'manufactor' => $item[ $this->ex_get_header_index( 'Производитель' ) ],
					'country'    => $item[ $this->ex_get_header_index( 'Страна' ) ],
					'short'      => $item[ $this->ex_get_header_index( 'Краткое описание' ) ],
					'full'       => ( $full_content !== null ? $this->ex_get_full_to_array( $full_content ) : '' ),
					'image'      => $item[ $this->ex_get_header_index( 'Изображение' ) ],
					'weight'     => $this->ex_get_option( $key - 1, 'Вес, кг' ),
					'engine'     => $this->ex_get_option( $key - 1, 'Тип двигателя' ),
					'power'      => $this->ex_get_option( $key - 1, 'Мощность, Вт' ),
					'options'    => $this->ex_get_value_options()[ $key - 1 ]
				];
			}
		}

		return $new_array;
	}

	public function ex_format_row_repeater( array $array, string $field ) {
		$return = [];
		foreach ( $array as $item ) {
			$return[] = [
				$field => $item
			];
		}

		return $return;
	}

	public function ex_save( $cat_id = null ) {
		$content = $this->ex_get_content();

		foreach ( $content as $item ) {
			$post_data = [
				'post_title'  => sanitize_text_field( $item['title'] ),
				'post_status' => 'publish',
				'post_author' => 1,
				'post_type'   => 'catalog',
			];

			$post_id = wp_insert_post( $post_data );
			if ( $post_id ) {

				if ( ! empty( $item['articul'] ) ) {
					update_field( 'arcticul', $item['articul'], $post_id );
				}
				if ( ! empty( $item['manufactor'] ) ) {
					update_field( 'manufacturer', $item['manufactor'], $post_id );
				}
				if ( ! empty( $item['country'] ) ) {
					update_field( 'country', $item['country'], $post_id );
				}
				if ( ! empty( $item['weight'] ) ) {
					$item_weight = $item['weight'];
					$item_weight = trim( $item_weight );
					$item_weight = str_replace( '(без батареи)', '', $item_weight );
					update_field( 'weight', $item_weight, $post_id );
				}
				if ( ! empty( $item['engine'] ) ) {
					update_field( 'engine', $item['engine'], $post_id );
				}
				if ( ! empty( $item['power'] ) && is_numeric( $item['power'] ) ) {
					update_field( 'power', $item['power'], $post_id );
				}
				if ( ! empty( $item['short'] ) ) {
					update_field( 'mini_text', $item['short'], $post_id );
				}

				if ( ! empty( $item['full'] ) ) {
					update_field( 'description', $this->ex_format_row_repeater( $item['full'], 'text' ), $post_id );
				}

				if ( ! empty( $item['options'] ) ) {
					$options_row = [];
					foreach ( $item['options'] as $key => $option ) {
						if ( $key ) {
							$options_row[] = [
								'title' => $key,
								'value' => $option
							];
						}
					}
					update_field( 'ch_list', $options_row, $post_id );
				}

				wp_set_object_terms( $post_id, $cat_id, 'catalog_cat' );

				$image_id = $this->ex_get_file( $item['articul'] );
				if ( ! empty( $image_id ) ) {
					set_post_thumbnail( $post_id, $image_id );
				}

			}
		}
	}
}