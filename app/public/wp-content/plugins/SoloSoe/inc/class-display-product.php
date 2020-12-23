<?php
use SOLOSOE\Search;

namespace SOLOSOE\Product;

defined('ABSPATH') || exit;

/**
 * Class for display product from API
 */
class SOLOSOE_DISPLAY_PRODUCT {

    public static $product = array(
        'info'                  => NULL,
        'info_error'            => NULL,
        'price'                 => NULL,
        'price_error'           => NULL,
        'cima_psuministro'      => NULL,
        'cima_psuministro_error'=> NULL,
        'cima_medicamento'      => NULL,
        'cima_medicamento_error'=> NULL,
        'prd_shops'             => NULL,
        'prd_shops_error'       => NULL,
    );
    
    public static $links = array(
        'link1' => NULL,
        'link2' => NULL,
        'link3' => NULL,
        'link4' => NULL,
        'link5' => NULL,
    );
   
    //Init class
    public static function init(){
        add_shortcode('display_product_card', [__CLASS__, 'render_product_card']);
        add_shortcode('display_posts_carousel', [__CLASS__, 'render_posts_carousel']);
        add_action('display_shops', [__CLASS__, 'display_shops'], 1, 1);
    }

    // Shortcose for display posts carousel
    public static function render_posts_carousel(){
        global $post;
        $posts = get_posts( array(
            'numberposts' => -1,
            'category'    => 0,
            'orderby'     => 'date',
            'order'       => 'DESC',
            'post_type'   => 'post',
            'suppress_filters' => true,
        ) );
        ?>

<div class="solosoe-custom-posts-loop container">
    <div class="row">
        <div class="owl-carousel owl-theme">

            <?php
        foreach( $posts as $post ):
            setup_postdata($post);    
        ?>
            <div id="<?=$post->ID?>" class="item box-item">
                 <div style="font-size:12px;display:flex;align-items:center;justify-content:space-between;margin-bottom: 5px;">
                    <p style="display:block;font-size:12px;margin:0px; color:#fff;">
						<?php $categories = get_the_category();
	                        foreach( $categories as $category ){
                                echo $category->name . ',';
                                }
                        ?>   
					 </p>
                    <span style="display:block;font-size:12px;color:#fff;">
                      <?php echo get_the_date(); ?>
                    </span>
                </div>
				
                <a href="<?php the_permalink(); ?>">
                    <?php echo get_the_post_thumbnail( $post->ID, array(150,150)); ?>
					<span class="linkSpanner"></span>
                </a>
               
				<div class="text">
				   <h6>
					  <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a> 
				   </h6>
					<span><?php //the_excerpt(); ?></span>
				</div>
            </div>
            <?php
        endforeach;
        ?>
        </div>
    </div>
</div>
<?php
            wp_reset_postdata();
    }

    // Take all API data
    public static function get_data(){
        if ( !empty($_REQUEST['prd_id']) ):
                    
            // get current product id 
            $product_id = $_REQUEST['prd_id'];
            
            //todo change - store urls at DB as plugin options without .'/?format=json'
            $prd_info_url = 'https://service.solosoe.com/services/product/'.$product_id;
            self::$links['link1'] = $prd_info_url;
            $prd_price_url = 'https://service.solosoe.com/services/crawling-data/optimal_price/?product_code='.$product_id;
            self::$links['link2'] = $prd_price_url;

            $product_info = wp_remote_get($prd_info_url);
            if (is_wp_error($product_info)):
                $product_info_error = $product_info->get_error_message();
                self::$product['info_error'] = $product_info_error;
            elseif( wp_remote_retrieve_response_code( $product_info ) == 500 ):
                self::$product['info_error'] = '500  Internal Server Error';
            elseif( wp_remote_retrieve_response_code( $product_info ) === 200 ):
                $info = self::$product['info'] = wp_remote_retrieve_body( $product_info );
            endif;

            $product_price = wp_remote_get($prd_price_url);
            if (is_wp_error($product_price)):
               $product_price_error = $product_price->get_error_message();
               self::$product['price_error'] = $product_price_error;
            elseif( wp_remote_retrieve_response_code( $product_price ) == 500 ):
                self::$product['price_error'] = '500  Internal Server Error';
            elseif( wp_remote_retrieve_response_code( $product_price ) === 200 ):
                self::$product['price']  = wp_remote_retrieve_body( $product_price );
            endif;

            // get products by shops
            $prd_shops_url = 'https://service.solosoe.com/services/crawling-data/?format=json&mst_prd_id='.$product_id;
            self::$links['link5'] = $prd_shops_url;
            $prd_shops = wp_remote_get($prd_shops_url, array('timeout'=>10));
            if (is_wp_error($prd_shops)):
               $prd_shops_error = $prd_shops->get_error_message();
               self::$product['prd_shops_error'] = $prd_shops_error;
            elseif( wp_remote_retrieve_response_code( $prd_shops ) == 500 ):
                self::$product['prd_shops_error'] = '500  Internal Server Error';
            elseif( wp_remote_retrieve_response_code( $prd_shops ) === 200 ):
                self::$product['prd_shops']  = wp_remote_retrieve_body( $prd_shops );
            endif;
                
            $info = json_decode($info);
            if (isset($info->cn_dot_7)):
                $cn_dot_7 = floor($info->cn_dot_7);
                $cn_dot_1_7 = substr($cn_dot_7, 0, 1);
            endif;
            if ( !is_null($cn_dot_7) && $cn_dot_1_7 >= 6):
                $cn_dot_7_tmp = $info->cn_dot_7;
                $cima_id = $cn_dot_7;

                $cima_psuministro_url = 'https://cima.aemps.es/cima/rest/psuministro/'.$cima_id;
                self::$links['link3'] = $cima_psuministro_url;
                $cima_psuministro = wp_safe_remote_request($cima_psuministro_url, array('timeout'=>20));
                if (is_wp_error($cima_psuministro)):
                    $cima_psuministro_error = $cima_psuministro->get_error_message();
                    self::$product['cima_psuministro_error'] = $cima_psuministro_error;
                elseif( wp_remote_retrieve_response_code( $cima_psuministro ) === 200 ):
                    self::$product['cima_psuministro'] = wp_remote_retrieve_body($cima_psuministro);
                endif;

                $cima_medicamento_url = 'https://cima.aemps.es/cima/rest/medicamento?cn='.$cima_id;
                self::$links['link4'] = $cima_medicamento_url;
                $cima_medicamento = wp_safe_remote_request($cima_medicamento_url, array('timeout'=>20));
                if (is_wp_error($cima_medicamento)):
                    $cima_medicamento_error = $cima_medicamento->get_error_message();
                    // if request return error - display alert
                    self::$product['cima_medicamento_error'] = $cima_medicamento_error;
                elseif( wp_remote_retrieve_response_code( $cima_medicamento ) === 200 ):
                    self::$product['cima_medicamento'] = wp_remote_retrieve_body($cima_medicamento);
                endif;

            endif;
            
            return self::$product;
        endif;
    }

    //  Shortcode for display product
    public static function render_product_card(){
        $prod_data = self::get_data();
        $cima_medicamento = json_decode($prod_data['cima_medicamento']);
        $info = json_decode($prod_data['info']);
        ob_start();
        ?>
<div id="solosoe-custom-templates" class="container">

    <?php 
        // if search resul page - display carousel before search form 
        if ( !empty($_REQUEST['prd_id']) ):
            echo self::render_posts_carousel();
        endif;
    ?>

    <!-- Search form-->
    <?php echo self::display_solr_search_form(); ?>

    <?php 
        if( current_user_can('manage_options') && !empty(self::$links['link1'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <h4 class="alert-heading">You see this message, becourse you are administrator!</h4>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <p>link1: <a href="<?=self::$links['link1'] ?>" class="alert-link"><?=self::$links['link1'] ?></a></p>
        <p>link2: <a href="<?=self::$links['link2'] ?>" class="alert-link"><?=self::$links['link2'] ?></a></p>
        <p>link3: <a href="<?=self::$links['link3'] ?>" class="alert-link"><?=self::$links['link3'] ?></a></p>
        <p>link4: <a href="<?=self::$links['link4'] ?>" class="alert-link"><?=self::$links['link4'] ?></a></p>
        <p>link5: <a href="<?=self::$links['link5'] ?>" class="alert-link"><?=self::$links['link5'] ?></a></p>
        <hr>
        <p class="mb-0">follow the links to view the returned data on services</p>
    </div>
    <?php
        endif;
            ?>
    <!-- Card Start
    <div class="card solosoe-main-product-data"> -->
        <?php if(!empty($_REQUEST['prd_id'])){
            $cls = 'display:block';
            $data = 'display:flex';
				
        }else{
            $cls = 'display:none';
            $data = 'display:none';
        } ?>


<!-- Dimple : 07-10-2020 -->

    <div id="img-test" style="<?=$data?>; width: 100%;position: fixed;z-index: 999;left: 0;top: 0;height: 100%;background: #fff;align-items: center">
        <img src="../wp-content/plugins/SoloSoe/asset/img/loader.gif" style="margin:0 auto;display:table;" >
    </div>

<!-- Dimple : 07-10-2020 -->
    <div class="container" id="Cima" style="<?=$cls?>;color: rgb(8,63,76);border-width: thin;border: solid;border-style: solid;margin-top: 20px; margin-bottom:20px;border-color: rgb(8,63,76,0.5);border-radius: 20px;">

    


        <!-- Product Name -->       
        <?php echo self::display_product_name($info); 
        if (isset($info->master_details))
            /* echo "<div class='row'><div class='col col-4'>";
            if (isset($info->images)  || isset($cima_medicamento->fotos)){
                echo self::display_products_imgs($info->images, $cima_medicamento->fotos);
            }
            ?>
            <div class="row" id="EAN-1" style="margin-right: 0px;margin-left: 0px;">
                <div class="col">
                    <p class="text-center" style="font-size: 19px;margin-top: 18px;margin-bottom: -4px;"><?=$info->ean?> </p>
                    <p class="text-center" style="color: rgba(8,63,76,0.42);">EAN</p>
                </div>
            </div>
            <?php 
            echo "</div>";
            //echo self::display_cima_medicamento_data(json_decode($prod_data['cima_medicamento']));
            echo "</div>"; */
            echo self::display_product_price($info, $prod_data['price'], $info->master_details); //price section
        
        ?>

        <!-- <div class="row solosoe-product-info"> 
            <div class="col-12"> -->
                <?php // echo self::display_cima_medicamento_data(json_decode($prod_data['cima_medicamento'])); ?>
         <!--   </div>
        </div> -->

  
        <div class="row text-right" style="margin-right: 0px;margin-left: 0px;margin-top: 10px;margin-bottom: 10px;">
        <!-- Carousel 
        <div class="col-md-4">
                <?php 
                           /* if (isset($info->images) || isset($cima_medicamento->fotos))
                                echo self::display_products_imgs($info->images, $cima_medicamento->fotos);
                            
                             if (isset($cima_medicamento->fotos)):
                                $fotos = $cima_medicamento->fotos;
                                if ( !empty($fotos) ): 
                                    foreach ($fotos as $foto):?>
                <img src="<?=$foto->url?>" alt="<?=$foto->tipo?>" class="img-thumbnail">
                <?php
                                    endforeach;
                                endif;
                            else:
                                echo "No";
                            endif; */
                            
                        ?>
            </div>-->
            <div class="col-lg-4 col-md-12 col-12">
                <?php 
                             if (isset($info->images) || isset($cima_medicamento->fotos)){
                                    echo self::display_products_imgs($info->images, $cima_medicamento->fotos);
                             }else{
                               // echo "No";
                             } 
							if($info->ean != null){	
							?>
							
                             <div class="row" id="EAN-1" style="margin-right: 0px;margin-left: 0px;">
                                <div class="col">
                                    <p class="text-center" style="font-size: 19px;margin-top: 18px;margin-bottom: -4px;"><?=$info->ean?> </p>
                                    <p class="text-center" style="color: rgba(8,63,76,0.42);">EAN</p>
                                </div>
                            </div>
                     <?php   }        /* if (isset($cima_medicamento->fotos)):
                                    $fotos = $cima_medicamento->fotos;
                                    if ( !empty($fotos) ): 
                                        foreach ($fotos as $foto):?>
                    <img src="<?=$foto->url?>" alt="<?=$foto->tipo?>" class="img-thumbnail">
                    <?php
                                        endforeach;
                                    endif;
                                else:
                                    echo "No";
                                endif;  */
                                
                            ?>  
            </div>
            <?php 
        $prd_shops = json_decode($prod_data['prd_shops']);
        if (!empty($prd_shops->results)):
            $prd_shops_results = $prd_shops->results;
        ?>
            <div class="col-lg-8 col-md-12 col-12">
                <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar product-table" style="height: 100%;max-height: 362px;font-size: 13px;margin-top: -2px;">
                        <table class="table">
                        <thead style="color: rgb(8,63,76);">
                            <tr style="font-size: 13px;">
                                <th></th>
                                <th class="text-left" style="padding-top: 2px;padding-bottom: 2px;color: rgba(8,63,76,0.57);width: 473px;">Nombre del Producto</th>
                                <th style="padding-top: 2px;padding-bottom: 2px;color: rgba(8,63,76,0.57);">Precio</th>
                                <th style="padding-top: 2px;padding-bottom: 2px;color: rgba(8,63,76,0.57);">Fecha</th>
                            </tr>
                        </thead>
                        <tbody style="height: 326px;">
                        <?php 
                            foreach ($prd_shops_results as $shop): 
                            ?>
                            <tr id="r1" style="height: 66px;">
                                <td style="width: 66px;padding-top: 5px;padding-bottom: 5px;">
                                <?php if (isset($shop->small_image)): ?>
                                <img src="<?=$shop->small_image ?>" style="width: 45px;">
                                <?php else: ?>
                                <img src="<?= plugins_url('SoloSoe/asset/img/noimage.png')?>" style="width: 45px;">
                                <?php endif; ?>
                                </td>
                                <td style="padding-top: 6px;padding-bottom: 6px;" width="68%">
                                    <div class="row">
                                        <div class="col product-name text-left" style="width: 100%;margin-right: 10px;"><a href="<?=$shop->product_url?>" target="_blank" style="font-size: 16px; color: #267f88;"><?=$shop->product_name?></a></div>
                                    </div>
                                    <div class="row">
                                        <div class="col product-name" style="width: 50%;max-width: 50%;height: 20px;">
                                            <p class="text-left" style="color: rgb(8,63,76); font-size: 13px"><?php $seller = $shop->seller;?><?=$seller->name?></p>
                                        </div>
                                        <div class="col product-name" style="height: 20px;">
                                            <p style="color: rgb(8,63,76); font-size: 13px"><?php $marketplace = $seller->marketplace;?><?=$marketplace->name?></p>
                                        </div>
                                    </div>
                                </td>
                                <td style="color: rgb(8,63,76);font-size: 18px;font-weight: bold;"><?=round($shop->sale_price,2).'&#8364;'?></td>
                                <td style="color: rgb(8,63,76);font-weight: 100;font-size:13px;"><?php $modified_date = date_parse($shop->process_modification_date); ?>
                        <?php echo $modified_date['day'] . '/' . $modified_date['month'] . '/' . $modified_date['year']; ?></td>
                            </tr>
                        <?php endforeach ?>
                        </tbody>
                    </table> 
                </div>
            </div>
        <?php 
        else: 
		if($info->product_description == NULL)
            {
                $i = 0;
            }
			?>
			<script type="text/javascript">
            //alert(<?php echo $i;?>);
            var i = <?php echo $i;?>;
            if(i == 0)
            {
                document.getElementById('product-data').style.display = 'none';
                document.getElementById('empt-data').style.display = 'none';
            }
        </script>
             <div class="col-md-8">
             <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar product-table">
                 <h5>ESTE PRODUCTO NO SE ENCUENTRA EN NUESTRA BASE DE DATOS</h5>
             </div>
             </div>
       <?php 
        endif; ?>
            </div>
                
        <?php 
                $cima_psuministro = json_decode($prod_data['cima_psuministro']);
                if (!empty($cima_psuministro->resultados)):
                    $resultados = $cima_psuministro->resultados;
                    //echo self::display_product_name($info);
                    echo self::display_cima_psuministro_data($info, $resultados[0], $cima_medicamento->fotos); //Red Block
                    //echo self::display_carousel_sec($info, json_decode($prod_data['cima_medicamento']));
                    echo self::display_cima_medicamento_data(json_decode($prod_data['cima_medicamento'])); // Second column
                    echo "</div>";
                else:
                    echo "<div class='row'><div class='col col-4'></div>";
                    echo self::display_cima_medicamento_data(json_decode($prod_data['cima_medicamento']));
                    echo "</div>";
                    //echo self::display_product_name($info);
                    /*  if (isset($info->master_details))
                        echo "<div class='row'><div class='col col-4'>";
                        if (isset($info->images)  || isset($cima_medicamento->fotos)){
                            echo self::display_products_imgs($info->images, $cima_medicamento->fotos);
                        }
                        ?>
                        <div class="row" id="EAN-1" style="margin-right: 0px;margin-left: 0px;">
                            <div class="col">
                                <p class="text-center" style="font-size: 19px;margin-top: 18px;margin-bottom: -4px;"><?=$info->ean?> </p>
                                <p class="text-center" style="color: rgba(8,63,76,0.42);">EAN</p>
                            </div>
                        </div>
                        <?php 
                        echo "</div>";
                        echo self::display_cima_medicamento_data(json_decode($prod_data['cima_medicamento']));
                        echo "</div>";
                        echo self::display_product_price($info, $prod_data['price'], $info->master_details); //price section */
                endif;
                ?>

        <?php if (!empty($cima_psuministro->resultados)): ?>
        <div class="row solosoe-product-info">
            <div class="col-12">
                <?php echo self::display_cima_medicamento_data_footer(json_decode($prod_data['cima_medicamento'])); ?>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <?php 
        // if if search page - display carousel after search form 
        if ( empty($_REQUEST['prd_id']) ):
            echo self::render_posts_carousel();
        endif;
    ?>
</div>
<?php
        return ob_get_clean(); 
    }
   
        
    //  Display cima product data from  https://cima.aemps.es/cima/rest/medicamento?cn=912485
    public static function display_cima_medicamento_data($medicamento){
        if (isset($medicamento->viasAdministracion))
            $viasAdministracion = $medicamento->viasAdministracion;
        
        if (isset($medicamento->formaFarmaceutica))
            $formaFarmaceutica = $medicamento->formaFarmaceutica;
        
        if (isset($medicamento->docs))
            $docs = $medicamento->docs;
        
        if (isset($medicamento->principiosActivos))
            $principiosActivos = $medicamento->principiosActivos;
        
        if (isset($medicamento->excipientes))
            $excipientes = $medicamento->excipientes;

        if (isset($medicamento->atcs))
            $atcs = $medicamento->atcs;

        
        if (!empty($viasAdministracion) && !empty($formaFarmaceutica)):
        ?>
<div class="col col-lg-8 col-12">
                <div class="row">
                    <div class="col align-self-end">
                        <div class="row">
                            <div class="col col-lg-9 col-12">
                                <p style="margin-bottom: 0px;color: rgb(8,63,76);"><?php echo $medicamento->labtitular; ?></p>
                                <p style="font-size: 9px;margin-bottom: 4px;color: rgb(8,63,76);">LABORATORIO</p>
                            </div>
                            <div class="col">
                                <div class="row" id="prospect" style="margin-top: 9px;">
                                <?php 
                                if ($docs): 
                                        $pdf_logo_url = SOLOSOE_URL . '/asset/img/pdf.svg';
                                        $html_logo_url = SOLOSOE_URL . '/asset/img/doc-file.svg';
                                ?>
                                    <div class="col text-right">
                                    <?php foreach ($docs as $doc): ?>
                                    <a href="<?= $doc->url; ?>" target="_blank"><img src="<?= $pdf_logo_url; ?>" style="width: 30px;margin-right: 14px;"></a>
                                    <?php endforeach;
                                    ?>
                                        <p class="text-center" style="font-size: 9px;margin-bottom: 4px;color: rgb(8,63,76);margin-left: -4px;">Ficha Tecnica</p>
                                    </div>
                                    <div class="col text-left" style="padding-right: 24px;">
                                    <?php foreach ($docs as $doc): ?>
                                    <a href="<?= $doc->urlHtml; ?>" target="_blank"><img src="<?= $html_logo_url; ?>" style="width: 30px;margin-left: -2px;"></a>
                                    <?php endforeach;
                                    ?>
                                        <p class="text-center" style="font-size: 9px;margin-bottom: 4px;color: rgb(8,63,76);margin-left: -32px;">Prospecto</p>
                                    </div>
                                    <?php    
                                endif;
                                ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col align-self-start col-lg-4 col-12">
                                <p style="font-size: 9px;margin-bottom: 4px;color: white;background-color: rgb(8,63,76);padding-left: 3px;padding-bottom: 1px;padding-top: 1px;width: 100%;"><strong>FORMAS FARMACÉUTICAS</strong></p>
                                <p style="margin-bottom: 0px;color: rgb(8,63,76);font-size: 15px;"><?php echo $formaFarmaceutica->nombre; ?></p>
                            </div>
                            <div class="col align-self-start col-lg-4 col-12" style="margin-left: 0;">
                                <p style="font-size: 9px;margin-bottom: 4px;color: white;background-color: rgb(8,63,76);padding-left: 3px;padding-bottom: 1px;padding-top: 1px;width: 100%;"><strong>VÍAS DE ADMINISTRACIÓN</strong><br></p>
                                <p style="margin-bottom: 0px;color: rgb(8,63,76);font-size: 15px;"><?php echo $viasAdministracion[0]->nombre; ?></p>
                            </div>
                            <div class="col align-self-start col-lg-4 col-12">
                                <p style="font-size: 9px;margin-bottom: 4px;color: white;background-color: rgb(8,63,76);padding-left: 3px;padding-bottom: 1px;padding-top: 1px;width: 100%;"><strong>DOSIS</strong><br></p>
                                <p style="margin-bottom: 0px;color: rgb(8,63,76);font-size: 15px;"><?php echo $medicamento->dosis; ?></p>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 8px;">
                            <div class="col align-self-start col-lg-6 col-12" style="padding-bottom: 10px;">
                            <?php if ($principiosActivos): ?>
                                <p style="font-size: 9px;margin-bottom: 4px;color: white;background-color: rgb(8,63,76);padding-left: 3px;padding-bottom: 1px;padding-top: 1px;width: 100%;"><strong>PRINCIPIOS ACTIVOS</strong><br></p>
                                <?php foreach ($principiosActivos as $activos): ?>
                                <p style="margin-bottom: 2px;color: rgb(8,63,76);font-size: 14px;margin-left: 10px;"><?= $activos->nombre.' '.$activos->cantidad.' '.$activos->unidad; ?></p>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            </div>
                            <div class="col align-self-start col-lg-6 col-12" style="padding-bottom: 10px;">
                            <?php if ($excipientes): ?>
                                <p style="font-size: 9px;margin-bottom: 4px;color: white;background-color: rgb(8,63,76);padding-left: 3px;padding-bottom: 1px;padding-top: 1px;width: 100%;"><strong>EXCIPIENTES</strong><br></p>
                                <?php foreach ($excipientes as $excipient): ?>
                                <p style="margin-bottom: 2px;color: rgb(8,63,76);font-size: 14px;margin-left: 10px;"><?= $excipient->nombre.' '.$excipient->cantidad.' '.$excipient->unidad; ?></p>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 8px;">
                            <div class="col align-self-start col-lg-6 col-12" style="padding-bottom: 10px;">
                                <p style="font-size: 9px;margin-bottom: 4px;color: white;background-color: rgb(8,63,76);padding-left: 3px;padding-bottom: 1px;padding-top: 1px;width: 100%;"><strong>CARACTERÍSTICAS</strong><br></p>
                                <p style="margin-bottom: 2px;color: rgb(8,63,76);font-size: 14px;margin-left: 10px;">SIN RECETA</p>
                            </div>
                            <div class="col align-self-start col-lg-6 col-12" style="padding-bottom: 10px;">
                            <?php if ($atcs): ?>
                                <p style="font-size: 9px;margin-bottom: 4px;color: white;background-color: rgb(8,63,76);padding-left: 3px;padding-bottom: 1px;padding-top: 1px;width: 100%;"><strong>CÓDIGOS ATC</strong><br></p>
                                <?php foreach ($atcs as $atc): ?>
                                <p style="margin-bottom: 2px;color: rgb(8,63,76);font-size: 14px;margin-left: 10px;"><?= $atc->codigo.' - '.$atc->nombre; ?></p>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<!-- Product psuministro data from cima -->
<?php
        endif; 
    }

    public static function display_cima_medicamento_data_footer($medicamento){
    ?>
<div class="card solosoe-cima-medicamento-product-footer-data">
    <div class="row justify-content-around">
        <div class="card bg-light xs-2">
            <div class="card-body">
                <h5 class="card-title">
                    <span class="product-footer-properties">Comercialiazado</span>
                    <?php 
                                if ($medicamento->comerc): 
                                    $class='slosoe-yes'; 
                                    $value='Si'; 
                                else: 
                                    $class='slosoe-no'; 
                                    $value='No';
                                endif;
                            ?>
                    <span class="solosoe-boolean-product-properties <?=$class; ?>"><?=$value; ?></span>
                </h5>
            </div>
        </div>
        <div class="card bg-light xs-2">
            <div class="card-body">
                <h5 class="card-title">
                    <span class="product-footer-properties">Require Receta</span>
                    <?php 
                                if ($medicamento->receta): 
                                    $class='slosoe-yes'; 
                                    $value='Si'; 
                                else: 
                                    $class='slosoe-no'; 
                                    $value='No';
                                endif;
                            ?>
                    <span class="solosoe-boolean-product-properties <?=$class; ?>"><?=$value; ?></span>
                </h5>
            </div>
        </div>
        <div class="card bg-light xs-1">
            <div class="card-body">
                <h5 class="card-title">
                    <span class="product-footer-properties">Generico</span>
                    <?php 
                                if ($medicamento->generico): 
                                    $class='slosoe-yes'; 
                                    $value='Si'; 
                                else: 
                                    $class='slosoe-no'; 
                                    $value='No';
                                endif;
                            ?>
                    <span class="solosoe-boolean-product-properties <?=$class; ?>"><?=$value; ?></span>
                </h5>
            </div>
        </div>
        <div class="card bg-light xs-1">
            <div class="card-body">
                <h5 class="card-title">
                    <span class="product-footer-properties">Conduc</span>
                    <?php 
                                if ($medicamento->conduc): 
                                    $class='slosoe-yes'; 
                                    $value='Si'; 
                                else: 
                                    $class='slosoe-no'; 
                                    $value='No';
                                endif;
                            ?>
                    <span class="solosoe-boolean-product-properties <?=$class; ?>"><?=$value; ?></span>
                </h5>
            </div>
        </div>
        <div class="card bg-light xs-2">
            <div class="card-body">
                <h5 class="card-title">
                    <span class="product-footer-properties">Triangulo</span>
                    <?php 
                                if ($medicamento->triangulo): 
                                    $class='slosoe-yes'; 
                                    $value='Si'; 
                                else: 
                                    $class='slosoe-no'; 
                                    $value='No';
                                endif;
                            ?>
                    <span class="solosoe-boolean-product-properties <?=$class; ?>"><?=$value; ?></span>
                </h5>
            </div>
        </div>
        <div class="card bg-light xs-2">
            <div class="card-body">
                <h5 class="card-title">
                    <span class="product-footer-properties">Huerfano</span>
                    <?php 
                                if ($medicamento->huerfano): 
                                    $class='slosoe-yes'; 
                                    $value='Si'; 
                                else: 
                                    $class='slosoe-no'; 
                                    $value='No';
                                endif;
                            ?>
                    <span class="solosoe-boolean-product-properties <?=$class; ?>"><?=$value; ?></span>
                </h5>
            </div>
        </div>
        <div class="card bg-light xs-2">
            <div class="card-body">
                <h5 class="card-title">
                    <span class="product-footer-properties">Biosimilar</span>
                    <?php 
                                if ($medicamento->biosimilar): 
                                    $class='slosoe-yes'; 
                                    $value='Si'; 
                                else: 
                                    $class='slosoe-no'; 
                                    $value='No';
                                endif;
                            ?>
                    <span class="solosoe-boolean-product-properties <?=$class; ?>"><?=$value; ?></span>
                </h5>
            </div>
        </div>
    </div>
</div>
<?php
    }

    //  Display search form
    public static function display_solr_search_form(){
        $spinner_url = SOLOSOE_URL . '/asset/img/spinner.gif';
        $prod_data1 = self::get_data();
        $info1 = json_decode($prod_data1['info']);
        ?>
<div id="solosoe-custom-templates" class="container p-3">
    <form>
        <div class="form-group search-box">
        <img src="<?= plugins_url('SoloSoe/asset/solsoe-logo-1.png')?>" class="logobing">
        <div class="input-group">
            <input id="solr-typeahead" type="search" class="search-field" placeholder="Código de Barras, CN o Nombre del producto" value="<?php //if(!empty($info1)): echo $info1->product_name; endif;?>" />
            <div class="input-group-append">
            <span class="input-group-text"><img src="<?= plugins_url('SoloSoe/asset/search.png')?>"></span>
            </div>
            <img class="Typeahead-spinner" src="<?= $spinner_url; ?>">
        </div>
           
        </div>
    </form>
</div>
<?php 
    }

    //  Display cima product data from  https://cima.aemps.es/cima/rest/psuministro/912485
    public static function display_cima_psuministro_data($product_info, $resultados, $cima_images){
        ?>

        <div class="row">
            <div class="col col-lg-4 col-12">
                <div class="row">
                    <div class="col" style="background-color: red;margin-left: 2px;">
                        <p class="text-center" data-bs-hover-animate="shake" style="color: rgb(255,255,255);background-color: #ff0000;font-size: 19px;filter: blur(0px);margin-bottom: -3px;">Problema de Suminstro</p>
                        <p class="text-center" style="margin-bottom: -2px;color: yellow;font-size: 17px;"><?php echo date("d/m/Y", substr($resultados->fini, 0, 10)); ?></p>
                        <p class="text-center" style="margin-bottom: 1px;font-size: 8px;color: white;"><strong>FECHA PREVISTA DE INICIO</strong></p>
                        <p class="text-center" style="margin-bottom: -5px;color: yellow;font-size: -4px;"><?php echo date("d/m/Y", substr($resultados->ffin, 0, 10)); ?></p>
                        <p class="text-center" style="margin-bottom: 3px;font-size: 8px;color: white;"><strong>FECHA PREVISTA FINALIZACIÓN</strong><br></p>
                        <p class="text-center" style="margin-bottom: 0px;font-size: 10px;color: white;"><?php echo $resultados->observ; ?><br></p>
                    </div>
                </div>
                <!-- <div class="row" style="margin-top: 9px;">
                    <div class="col"><img src="<?= plugins_url('SoloSoe/assets/img/51347_materialas.jpg?h=b07a8e3f8074b8caf5e72d0de0db6636')?>" style="width: 220px;margin-left: 1px;"><img src="<?= plugins_url('SoloSoe/assets/img/51347_formafarmac.jpg?h=c0d3291a62d634f2a239f7aa1bf728bd')?>" style="width: 159px;margin-left: 25px;"></div>
                </div> -->
                 <!-- <div class="row" style="margin-top: 9px;">
                    <div class="col">
                    <?php if (isset($product_info->images) || isset($cima_images)){
                        // echo self::display_products_imgs($product_info->images, $cima_images);
                    } ?>
                    </div>
                </div> 
                <div class="row" id="EAN-1" style="margin-right: 0px;margin-left: 0px;">
                    <div class="col">
                        <p class="text-center" style="font-size: 19px;margin-top: 18px;margin-bottom: -4px;"><?= $product_info->ean ?></p>
                        <p class="text-center" style="color: rgba(8,63,76,0.42);">EAN</p>
                    </div>
                </div> -->
             </div>
             
 
  <?php  }
    //  Display cima product data from  https://cima.aemps.es/cima/rest/psuministro/912485
    public static function display_product_name($product_info){
    ?>
        <div class="row" id="product-name">
        <div class="col">
    <p class="text-center" style="font-size: 24px;margin-top: 12px;margin-bottom: -5px;"><strong><?php echo $product_info->product_name; ?></strong></p>
    <p class="text-center" style="margin-bottom: 2px;color: rgba(8,63,76,0.5);">Nombre del Producto</p>
        </div>
    </div>
<?php
    }
    public static function display_product_price($product_info, $product_price, $master_details){
        if (!empty($product_price = json_decode($product_price))):
        ?>
       <!-- <div class="row" id="product-name">
            <div class="col">
        <p class="text-center" style="font-size: 24px;margin-top: 12px;margin-bottom: -5px;"><strong><?php //echo $product_info->product_name; ?></strong></p>
        <p class="text-center" style="margin-bottom: 2px;color: rgba(8,63,76,0.5);">Nombre del Producto</p>
            </div>
        </div> -->
        <div class="row .flex-row" id="product-data">
            <div class="col-lg-4 col-md-12 col-12  " id="column-6" style="padding-right: 0px;padding-left: 0px;">
            <?php if (!empty($master_details)): ?>
                <div class="table-responsive text-center">
                    <table class="table table-sm" style="font-size: 16px;">
                        <thead class="text-center">
                            <tr style="background-color: rgb(255,193,7);height: 100%;">
                                <th style="height: 100%;padding-bottom: 0px;padding-top: 0px;">MKT</th>
                                <th style="height: 100%;padding-top: 0px;padding-bottom: 0px;">Nº</th>
                                <th style="height: 100%;padding-top: 0px;padding-bottom: 0px;">Min €</th>
                                <th style="height: 100%;padding-bottom: 0px;padding-top: 0px;">Max €</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            foreach ($master_details as $details): ?>
                            <tr>
                                <td style="padding-bottom: 0px;padding-top: 0px;"><?php echo $details->marketplace;?></td>
                                <td style="padding-bottom: 0px;padding-top: 0px;"><?php echo $details->no_of_shops;?></td>
                                <td style="padding-bottom: 0px;padding-top: 0px;"><?php echo $details->min_price;?></td>
                                <td style="padding-bottom: 0px;padding-top: 0px;"><?php echo $details->max_price;?></td>
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
                <!-- <?php 
                // else:  
                    ?>
                <div class="alert alert-light" role="alert">
                    <h4 class="alert-heading">No se ha encontrado en Internet!</h4>
                </div> -->
                <?php
                endif; 
                ?>
                <!-- <div class="row" id="image" style="margin-right: 0px;margin-left: 0px;">
                    <div class="col" style="margin-top: 23px;"><img style="width: 100%;height: 100%;border-radius: 25px;border: inherit;margin-left: -2px;" src="/assets/img/image.jpeg?h=88bd8ae7fbc4bbc070bafd8841e3e29d"></div>
                </div>
                <div class="row" id="EAN-1" style="margin-right: 0px;margin-left: 0px;">
                    <div class="col">
                        <p class="text-center" style="font-size: 19px;margin-top: 18px;margin-bottom: -4px;">8470007056577</p>
                        <p class="text-center" style="color: rgba(8,63,76,0.42);">EAN</p>
                    </div>
                </div> -->
            </div>
            <div class="col-lg-8 col-md-12 col-12  " id="column-2" style="padding-right: 0px;padding-left: 0px;">
                <div class="row" style="margin-right: 0px;margin-left: 0px;">
                    <div class="col" style="height: 100%;">
                        <p class="solsoe-prod-desc" id="pr-desc" style="padding-top: 6px;margin-top: 12px;font-size: 16px"><?php echo $product_info->product_description; ?></p>
                    </div>
                </div>
                <div class="row" style="margin-right: 0px;margin-left: 0px;">
                    <div class="col col-md-3 col-12" id="shops-number" style="border-radius: 20px;border: initial;background-color: rgba(8,63,76,0.1);height: 100%;margin-left: 22px;">
                        <p class="text-center" style="margin-bottom: -10px;margin-top: 0px;font-size: 30px;"><strong><?php echo $product_info->no_of_shops ?></strong></p>
                        <p class="text-center" style="color: rgba(8,63,76,0.42);font-size: 10px;margin-top: -10px;">Nº de Comercios</p>
                    </div>
                    <div class="col col-md-5 col-12" id="price-range" style="border-radius: 20px;border: initial;background-color: rgba(8,63,76,0.1);height: 100%;margin-right: 14px;margin-left: 14px;width: 30%;max-width: 36%;">
                        <div class="row" style="height: 85%;">
                            <div class="col col-6" style="height: 70%;">
                                <p class="text-center" style="margin-top: 4px;font-size: 30px;margin-bottom: 0px;margin-right: -43px;"><?php echo $product_info->min_sale_price; ?>€</p>
                            </div>
                            <div class="col col-md-6 " style="height: 70%;">
                                <p class="text-center" style="margin-top: 4px;font-size: 30px;margin-bottom: 0px;margin-left: -43px;"><?php echo $product_info->max_sale_price; ?>€</p>
                            </div>
                        </div>
                        <div class="row" style="height: 15%;;">
                            <div class="col" style="height: 20%;">
                                <p class="text-center" style="color: rgba(8,63,76,0.42);font-size: 10px;margin-top: -9px;">Rango de precios Online</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-12" id="optimal-price" style="border-radius: 20px;border: initial;background-color: rgb(255,193,7);height: 100%;margin-right: 22px;">
                        <p class="text-center" style="margin-bottom: -10px;margin-top: 0px;font-size: 30px;"><strong><?php echo $product_price->price; ?>€</strong></p>
                        <p class="text-center" style="margin-bottom: 0px;color: rgba(8,63,76,0.42);font-size: 10px;margin-top: -2px;">Precio Competitivo</p>
                    </div>
                </div>
                
            </div>
        </div>
          
<!-- <div class="card-block px-6">
   <h4 class="card-title">
        <small class="text-muted price"><?php //echo $product_info->ean; ?></small>
        
    </h4> -->
    <!-- <h5 class="card-subtitle mb-2">
        <small class="solosoe-pr-comercios text-muted">№ de Comercios: </small>
        <strong><?php //echo $product_info->mst_prd_id ?></strong>
        <small class="solosoe-pr-rango-precios text-muted">Rango de precios: </small>
        <strong><?php //echo $product_info->min_sale_price; ?> - <?php //echo $product_info->max_sale_price; ?> €</strong>
        <div id="solosoe-recommended-price" class="title badge badge-warning">Precio Competitevo <span
                class="solosoe-optimal-price-big"><?php //echo $product_price->price; ?> €</span></div>
    </h5> -->
    <!-- <div class="product-description-wrapper">
        <div id="pr-desc" class="card-text"></div>
    </div> -->
<!-- </div> -->
<?php
        endif;
    }
    
    //  Help function for display avalible shops
    public static function display_shops($master_details){
        //ob_start();
        foreach ($master_details as $details): ?>
<div class="card-link">
    <h5>
        <span class="badge badge-success">
            <?php echo $details->no_of_shops;?>
        </span>
        <?php echo $details->marketplace;?>
    </h5>
    <span><?php echo $details->min_price . ' - ' . $details->max_price;?>€</span>
</div>
<?php 
        endforeach;
        //return ob_get_clean(); 
    }


//  Help function for display avalible shops
public static function display_carousel_sec($infos,$cima_medicamentos){
    ?>

    <div class="col-md-4 ">
    <?php 
                if (isset($infos->images))
                    echo self::display_products_imgs($infos->images);
                
                if (isset($cima_medicamentos->fotos)):
                    $fotos = $cima_medicamentos->fotos;
                    if ( !empty($fotos) ): 
                        foreach ($fotos as $foto):?>
    <img src="<?=$foto->url?>" alt="<?=$foto->tipo?>" class="img-thumbnail">
    <?php
                        endforeach;
                    endif;
                else:
                    "No";
                endif;
            ?>
    </div>

            <?php }


    //  Display carousel products images
    public static function display_products_imgs($images,$cima_immages){
 
        if (!empty($images) || !empty($cima_immages)):
    ?>
<div id="CarouselSolosoe" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        <?php foreach ($images as $key=>$value): ?>
        <li data-target="#CarouselSolosoe" data-slide-to="<?= $key; ?>" <?php if ($key == 0): ?> class="active"
            <?php endif;?>></li>
        <?php endforeach; ?>
    </ol>

    <div class="carousel-inner">
        <?php foreach ($cima_immages as $key=>$value1): ?>
        <div class="carousel-item<?php if ($key == 0): ?> active<?php endif;?>">
            <img class="d-block" src="<?=$value1->url?>">

        </div>
        <?php endforeach; ?>
        <?php foreach ($images as $key=>$value): ?>
        <div class="carousel-item<?php if(empty($cima_immages)): if ($key == 0): ?> active <?php endif; endif; ?>">
            <img class="d-block" src="<?=$value; ?>">
        </div>
        <?php endforeach; ?>
    </div>
    <?php if(empty($cima_immages)): if ($key == 0): ?> active <?php endif; endif; ?>
    <a class="carousel-control-prev" href="#CarouselSolosoe" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#CarouselSolosoe" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>

</div>

<?php
        endif;
    }

    //http://34.243.79.103:8000/services/crawling-data/?format=json&mst_prd_id=78511
    public static function display_product_lists_by_shops($product_list){}

}

SOLOSOE_DISPLAY_PRODUCT::init();