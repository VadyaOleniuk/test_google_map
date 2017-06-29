<div class="center_box cb">
<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
				<div class="uo_tabs cf">
					<a href="#"><span>profile</a>
					<a href="#"><span>Reviews</span></a>
					<a href="#"><span>orders</span></a>
					<a href="#" class="active"><span>My Address</span></a>
					<a href="#"><span>Settings</span></a>
				</div>
				<div class="page_content bg_gray">
					<div class="uo_header">
						<div class="wrapper cf">
							<div class="wbox ava">
								<figure><img src="imgc/user_ava_1_140.jpg" alt="Helena Afrassiabi" /></figure>
							</div>
							<div class="main_info">
								<h1>Helena Afrassiabi</h1>
								<div class="midbox">
									<h4>560 points</h4>
									<div class="info_nav">
										<a href="#">Get Free Points</a>
										<span class="sepor"></span>
										<a href="#">Win iPad</a>
									</div>
								</div>
								<div class="stat">
									<div class="item">
										<div class="num">30</div>
										<div class="title">total orders</div>
									</div>
									<div class="item">
										<div class="num">14</div>
										<div class="title">total reviews</div>
									</div>
									<div class="item">
										<div class="num">0</div>
										<div class="title">total gifts</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					



					<div class="uo_body">
						<div class="wrapper">
							<div class="uofb cf">
								<div class="l_col adrs">
									<h2>Add New Address</h2>
<?php if(isset($error)):?><div class="error l_col adrs"> Invalid data you entered</div><?php endif;?>
                                                                        <form action="<?= Url::to()?>" method="POST">
										<div class="field">
											<label>Name *</label>
											<input type="text" value="" palceholder="" name="UsersAdress[name]" class="vl_empty" />
										</div>
										<div class="field">
											<label>Your city *</label>
											<select class="vl_empty" name="UsersAdress[city_id]">
                                                                                            
                                                                                            <option class="plh"></option>
												
												<?php
                                                                                                foreach ($city as $val): 
                                                                                                ?>
                                                                                                    <option value="<?= $val->id ?>"><?= $val->name ?></option>
                                                                                                <?php endforeach;?> 
											</select>
										</div>
										<div class="field">
											<label>Your area *</label>
                                                                                        <select  name="UsersAdress[area_id]">
												<option class="plh"></option>
												<?php
                                                                                                foreach ($area as $val):                                                                                                  
                                                                                                ?>
                                                                                                    <option value="<?= $val->id ?>"><?= $val->name ?></option>
                                                                                                <?php endforeach;?> 											</select>
										</div>
										
										<div class="field">
											<label>Street</label>
											<input type="text" value="" palceholder="" name="UsersAdress[street]" class="vl_empty" />
										</div>
										<div class="field">
											<label>House # </label>
											<input type="text" value="" name="UsersAdress[house]" palceholder="House Name / Number" />
										</div>
										
										<div class="field">
											<label class="pos_top">Additional information</label>
                                                                                        <textarea name="UsersAdress[additional_information]"></textarea>
										</div>
										<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
										<div class="field">
											<input type="submit" value="add address" class="green_btn" />
										</div>
									</form>
								</div>
								
								<div class="r_col" onload="loadScript()">
									<h2>My Addresses</h2>									
									
									<div class="uo_adr_list">
                                                                            
                                                                                <?php
                                                                               // if(empty($adress)):                                                                               
                                                                                foreach ($adress as $val): 
                                                                                    $city = $val->city;
                                                                                    $area = $val->area;    
                                                                                ?>
                                                                                    <div class="item">
                                                                                            <h3><?= $val->name ?></h3>
                                                                                            <p><?= $area->name ?>, <?= $city->name ?>, <?= $val->street ?>, <?= $val->house ?>, <?= $val->additional_information ?>  </p>
                                                                                            <div class="google-map" style="height:400px;" id="map_<?=$val->id?>" data-lat="<?= $val->lat ?>" data-lng="<?= $val->lng ?>"></div>
                                                                                                <div class="actbox">
                                                                                                    <a href="#" class="bcross"></a>
                                                                                            </div>
                                                                                    </div>
                                                                                <?php
                                                                                endforeach;
                                                                            //    endif;
                                                                                ?>    
																		
									</div>
								</div>
							</div>
						</div> <script>
    var url = '<?php echo Url::to(['site/delete'])?>';

    </script>
                                            
					</div>
				</div>
			</div>
		</div>
                <script>

                    </script>
                
<?php
$js = <<< JS
       
    function initMap() {
        $( ".uo_adr_list div > .google-map").each( function( index, element) {
            //var uluru = {lat: $( element).attr( "data-lat"), lng: $( element).attr( "data-lng")};
            var uluru = new google.maps.LatLng($( element).attr( "data-lat"), $( element).attr( "data-lng"));
            var map = new google.maps.Map(document.getElementById($( element).attr( "id")), {
              zoom: 12,
              center: uluru
            });
            var marker = new google.maps.Marker({
              position: uluru,
              map: map
            });
        });
    }        
    initMap();   
        
        
        
        
        $(function() {
  $(".bcross").on("click", function(){
       console.log($(this).parent(".item"));
        el = $(this).parents(".item");
        el.hide();
        return false;
      });
        });
JS;
$this->registerJs($js);
?>