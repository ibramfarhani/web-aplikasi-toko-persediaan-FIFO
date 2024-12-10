<?php

class backend{
	public $f;private $t;private $p;private $a;private $c;
	function __construct($h,$u,$p,$d){
		global $panel;global $app;global $copyright;global $base;
		$this->cn = @new mysqli($h,$u,$p,$d);
		if($this->cn->connect_error){echo "error:".$this->cn->connect_error;}
		$this->f=basename($_SERVER["SCRIPT_NAME"]);$this->b=$base;$this->p=$panel;$this->a=$app;$this->c=$copyright;
	}
	function close(){
	    $this->cn->close();
	}
	function content(){
		if(isset($_REQUEST['goLogin'])){
			if($this->auth($_REQUEST['username'],$_REQUEST['password'],$_REQUEST['level'])==true){
				if($_SESSION['level']=='admin'){
				echo "<script>self.location='".$this->p."/action/dashboard'</script>";
				}
				else{
					echo "<script>self.location='".$this->p."/action/penjualan'</script>";
				}
			}
			else{
				echo "<script>alert('Login Gagal!')</script>";
			}
		}		
		if(isset($_SESSION['level'])){ 
			if(isset($_REQUEST['table'])){$this->t=$_REQUEST['table'];}
			if(isset($_REQUEST['action'])){$action=$_REQUEST['action'];}else{$action="read";}
			if(isset($_REQUEST['id'])){$id=$_REQUEST['id'];}
			if(method_exists($this,$action)){
				if(isset($id)){$this::$action($id);}else{$this::$action();}
			}
		}
		else{
			$this->login();
		}
	}
	function enum($t,$f){
		return explode("','",substr($this->cn->query("SELECT COLUMN_TYPE FROM information_schema.COLUMNS WHERE TABLE_NAME = '$t' AND COLUMN_NAME = '$f'")->fetch_array()[0],6,-2));
	}
	function tables(){
		$rs=$this->cn->query("SHOW TABLES");
		$table=array();
		while($r=mysqli_fetch_array($rs)){
			$table[]=$r[0];
			}
		return $table;
	}
	function create(){
		$rs=$this->cn->query("SELECT * from ".$this->t);
		$nf=$rs->field_count;
		//echo "<i class='fa fa-camera'></i>";
		echo "<form action='".$this->p."/table/".$this->t."/action/save' method='post' enctype='multipart/form-data'>";
		for($i=1;$i<$nf;$i++){
			$name=$rs->fetch_field_direct($i)->name;
			$tp=$rs->fetch_field_direct($i)->type;
			$fl=$rs->fetch_field_direct($i)->flags;//echo $tp."'".$fl."";
			switch($tp){
				case 3:
					if(substr($name,0,3)=='id_'){
						$rsx=$this->cn->query("select * from ".substr($name,3));while($rx=mysqli_Fetch_array($rsx)){$rsi[]=$rx[0];$rsv[]=$rx[1];}
						echo "<div class='form-group row'>
                                <label for='$name' class='col-sm-2 col-form-label'>".ucwords(str_replace("_"," ",$name))."</label>
                                <div class='col-sm-10'>
                                    <select class='form-control' name='$name' required><option></option>";
			                            foreach (array_combine($rsi, $rsv) as $si => $sv) {
						                    echo "<option value='$si'>$sv</option>";	
						                }
			                    echo "</select>";
	                    echo "</div>
	                    </div>";
					}
					else{
	                    echo "<div class='form-group row'>
							<label for='$name' class='col-sm-2 col-form-label'>".ucwords(str_replace("_"," ",$name))."</label>
							<div class='col-sm-10'>
								<input type='number' class='form-control' id='$name' name='$name' placeholder='$name' required>
							</div>
							</div>";
					}
					break;
				case 252:
					if($fl==144||$fl==4241){
						echo "<div class='form-group row'>
                            <label for='$name' class='col-sm-2 col-form-label'>".ucwords(str_replace("_"," ",$name))."</label>
                            <div class='col-sm-10'>
                                <input type='file' class='form-control' id='$name' name='$name' placeholder='$name' required>
                            </div>
                        </div>";

					}
					else{
						echo "<div class='form-group row'>
                            <label for='$name' class='col-sm-2 col-form-label'>".ucwords(str_replace("_"," ",$name))."</label>
                            <div class='col-sm-10'>
                                <textarea cols=50 rows=5 class='form-control' name='$name' id='$name' placeholder='$name' required></textarea>
                            </div>
                        </div>";

					}
					break;
				case 10:
					echo "<div class='form-group row'>
							<label for='$name' class='col-sm-2 col-form-label'>".ucwords(str_replace("_"," ",$name))."</label>
							<div class='col-sm-10'>
								<input type='date' class='form-control' id='$name' placeholder='$name' name='$name' required>
							</div>
						  </div>";
					
					break;
				case 254:
					if($fl==4353||$fl==256){
						$enum=$this->enum($this->t,$name);
						echo "<div class='form-group row'>
								<label for='$name' class='col-sm-2 col-form-label'>".ucwords(str_replace("_"," ",$name))."</label>
								<div class='col-sm-10'>
									<select class='form-control' name='$name' required><option></option>";
										foreach($enum as $e){echo "<option value='$e'>$e</option>";}
								echo "</select>
								</div>
							   </div>";
					}
					else{
						
						
						echo "<div class='form-group row'>
								<label for='$name' class='col-sm-2 col-form-label'>".ucwords(str_replace("_"," ",$name))."</label>
								<div class='col-sm-10'>
									<input type='text' class='form-control' id='$name' placeholder='$name' name='$name' required>
								</div>
							  </div>";
						
					}
					break;
				default:
					if($name=='koordinat'){
						
							echo "<div class='form-group row'>
							<label for='$name' class='col-sm-2 col-form-label'>".ucwords(str_replace("_"," ",$name))."</label>
							<div class='col-sm-10'>";
								echo "<div class='input-group mb-1'>
            <input type='text' class='form-control' id='$name' placeholder='$name' name='$name' required>
                    <div class='input-group-append'>
                    <button type='button' class='btn btn-primary' data-toggle='modal' data-target='#exampleModal'>Map</button>
                    </div>
                </div>";
							echo "</div>
						</div>";
							echo "
							<!-- Button trigger modal -->


<!-- Modal -->
<div class='modal fade' id='exampleModal' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
  <div class='modal-dialog' role='document'>
    <div class='modal-content'>
      <div class='modal-header'>
        <h5 class='modal-title' id='exampleModalLabel'>Pilih Lokasi</h5>
        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
        </button>
      </div>
      <div class='modal-body'>
        ";
		?>
		<style>
		/* Change cursor when mousing over clickable layer */
.leaflet-clickable {
  cursor: crosshair !important;
}
/* Change cursor when over entire map */
.leaflet-container {
  cursor: help !important;
}
		</style>
		<div id="map" style="height: 250px;"></div>
		
<script>
//0.7976088,127.3342693
	var map = L.map('map').setView([-7.463732140598282, 112.58516899454024], 12);

	var tiles = L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFzYnVkaXlvbm8iLCJhIjoiY2t5Y2FrZTFtMDVzbjJvbzQ2cGFhcTVweSJ9.TL96f8ukvbxoBYVh0bNuZg', {
		maxZoom: 18,
		attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, ' +
			'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
		id: 'mapbox/streets-v11',
		tileSize: 512,
		zoomOffset: -1
	}).addTo(map);
	
	//var marker = L.marker([-7.449718418500336, 112.57246191616002]).addTo(map);
	map.on('click', function(e){
  var coord = e.latlng;
  var lat = coord.lat;
  var lng = coord.lng;
  //console.log("You clicked the map at latitude: " + lat + " and longitude: " + lng);
  //document.getElementById('koordinat').value=latlng.lat + ', ' + latlng.lng;
  //alert(lat+','+lng);
  document.getElementById("koordinat").value=lat+','+lng;
  });
	///////

</script>
		
		<?php
		echo "
      </div>
      <div class='modal-footer'>
        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
      </div>
    </div>
  </div>
</div>
							";
						}else{
					echo "<div class='form-group row'>
							<label for='$name' class='col-sm-2 col-form-label'>".ucwords(str_replace("_"," ",$name))."</label>
							<div class='col-sm-10'>
								<input type='text' class='form-control' id='$name' placeholder='$name' name='$name' required>
							</div>
						</div>";}
					break;
			}
		}
		echo "<div class='form-group row'>
    <label for='save' class='col-sm-2 col-form-label'></label>
    <div class='col-sm-10'>
      <input type=submit class='btn btn-primary' value=save></form>
    </div>
  </div>";
			
	}
	function save(){
		$rs=$this->cn->query("SELECT * from ".$this->t);
		$nf=$rs->field_count;
		for($i=1;$i<$nf;$i++){
			$d=$rs->fetch_field_direct($i)->name;
			$tp=$rs->fetch_field_direct($i)->type;
			$fl=$rs->fetch_field_direct($i)->flags;
			switch($tp){
				case 252:
					if($fl==144||$fl==4241){
						if(is_uploaded_file($_FILES[$d]['tmp_name'])){
							/* */
								$img=$_FILES[$d]['name'];
								$fileExt = pathinfo($_FILES[$d]['name'], PATHINFO_EXTENSION);
								move_uploaded_file($_FILES[$d]['tmp_name'], $img);
								list($w, $h) = getimagesize($img);
								$w2 = 200;$d = $w / $w2; $h2 = $h / $d;
          						$tn = imagecreatetruecolor($w2, $h2) ;
          						
								
								if($fileExt=='jpg'){
									$image = imagecreatefromjpeg($img) ;
									imagecopyresampled($tn, $image, 0, 0, 0, 0, $w2, $h2, $w, $h) ;
									imagejpeg($tn, 'tmp.jpg', 100) ;
									$data[]=mysqli_real_escape_string($this->cn,file_get_contents('tmp.jpg'));
									unlink('tmp.jpg');
								}
								else{
									$image = imagecreatefrompng($img) ;
									imagecopyresampled($tn, $image, 0, 0, 0, 0, $w2, $h2, $w, $h) ;
									imagepng($tn, 'tmp.png', 0) ;
									$data[]=mysqli_real_escape_string($this->cn,file_get_contents('tmp.png'));
									unlink('tmp.png');
								}
								unlink($img);
								
							/* */
							//$data[]=mysqli_real_escape_string($this->cn,file_get_contents($_FILES[$d]['tmp_name']));
						}
						else{
							$data[]='';
						}
					}
					else{
						$data[]=mysqli_real_escape_string($this->cn,$_REQUEST[$d]);
					}
					break;
				case 10:
					$data[]=date('Y-m-d',strtotime($_REQUEST[$d]));
					break;
				default:
					$data[]=$_REQUEST[$d];
					break;
				}	
			}
		$this->cn->query("INSERT INTO ".$this->t." VALUES(null,'".implode("','",$data)."')");
		if ($row['max_kode'] == null) {
			$kode_barang = 'BR001';
		} else {
			$kode_barang = 'BR' . sprintf('%03d', intval($row['max_kode']) + 1);
		}
		echo "<script>alert('Data Tersimpan!');self.location='".$this->p."/table/".$this->t."'</script>";
	}
	function edit($id){
		$rs=$this->cn->query("SELECT * from ".$this->t." WHERE id_".$this->t."='$id'");
		$nf=$rs->field_count;
		while($r=$rs->fetch_array()){
		echo "<form action='".$this->p."/table/".$this->t."/action/update' method='post'  enctype='multipart/form-data'><input type=hidden name='id' value='$id'>";
		for($i=1;$i<$nf;$i++){
			$name=$rs->fetch_field_direct($i)->name;
			$tp=$rs->fetch_field_direct($i)->type;
			$fl=$rs->fetch_field_direct($i)->flags;
			echo "<div class='form-group'><label for='$name'><b>".ucwords(str_replace("id_","",$name))."</b></label><br>";
			switch($tp){
			    case 3:
			        if(substr($name,0,3)=='id_'){
			            $rsx=$this->cn->query("select * from ".substr($name,3));
			            echo "<select name='$name' class='form-control'>";
			            while($rx=$rsx->fetch_array()){
			                echo "<option value='$rx[0]'";
			                if($rx[0]==$r[$i]){echo " selected";}
			                echo ">";if(substr($name,3)=='wali'){echo $rx['kelas']."-";}echo "$rx[1]</option>";
			            }
			            echo "</select>";
			        }
			        else{
			            echo "<input type='text' class='form-control' name='".$name."' value='".$r[$i]."'>";
			        }
			        break;
				case 252:
					if($fl==144||$fl==4241){
						echo "<img src='data:image/jpg;base64,".base64_encode($r[$i])."' width=150>";
						echo "<input type='file' class='form-control' name='".$name."'>";
					}
					else{
						echo "<textarea cols=50 rows=5 class='form-control' name='".$name."'>".$r[$i]."</textarea>";
					}
					break;
				case 10:
					echo "<input type='date' class='form-control' name='".$name."' value='".$r[$i]."'>";
					break;
				case 254:
					if($fl==4353||$fl==256){
						$enum=$this->enum($this->t,$name);
						echo "<select class='form-control' name='$name'><option></option>";
						foreach($enum as $e){echo "<option value='$e'";if($e==$r[$i]){echo " selected";}echo ">$e</option>";}
						echo "</select>";
					}
					else{
						echo "<div class='form-group'><label for='$name'><b>$name</b></label><br><input type='text' class='form-control'  name='".$name."'></div>";
					}
					break;
				default:
					echo "<input type='text' class='form-control' name='".$name."' value='".$r[$i]."'>";
					break;
			}
			echo "</div>";
		}
		echo "<input type=submit class='btn btn-primary' value=update></form>";		
		}
	}	
	function update($id){
		$rs=$this->cn->query("SELECT * from ".$this->t." where id_".$this->t."='$id'");
		$nf=$rs->field_count;
		while($r=mysqli_fetch_array($rs)){
		for($i=1;$i<$nf;$i++){
			$d=$rs->fetch_field_direct($i)->name;
			$tp=$rs->fetch_field_direct($i)->type;
			$fl=$rs->fetch_field_direct($i)->flags;
			switch($tp){
			    case 3:
			        $data[]=$d."='".$_REQUEST[$d]."'";
			        break;
				case 252:
					if($fl==144||$fl==4241){
						if(is_uploaded_file($_FILES[$d]['tmp_name'])){$data[]=$d."='".mysqli_real_escape_string($this->cn,file_get_contents($_FILES[$d]['tmp_name']))."'";}
					}
					else{
						$data[]=$d."='".mysqli_real_escape_string($this->cn,$_REQUEST[$d])."'";
					}
					break;
				case 10:
					$data[]=$d."='".date('Y-m-d',strtotime($_REQUEST[$d]))."'";
					break;
				default:
					$data[]=$d."='".$_REQUEST[$d]."'";
					break;
				}	
			}	
			}
		$this->cn->query("UPDATE ".$this->t." SET ".implode(",",$data)." WHERE id_".$this->t."='$id'");
		//echo "UPDATE ".$this->t." SET ".implode(",",$data)." WHERE id_".$this->t."='$id'";
		echo "<script>alert('Data Terupdate!');self.location='".$this->p."/table/".$this->t."'</script>";
	}
	function del($id){
		$rs=$this->cn->query("DELETE from ".$this->t." WHERE id_".$this->t."='$id'");
		echo "<script>alert('Data Dihapus!');self.location='".$this->p."/table/".$this->t."'</script>";
	}		
	function read(){
	    if(!isset($this->t)){$this->dashboard();exit();}
		//////////////
	echo "<h2 class='text-center'>".strtoupper($this->t)."</h2>";
	if(!isset($_REQUEST['page'])){$page=1;$page_next=2;$page_prev=null;$page_max=3;}else{$page=$_REQUEST['page'];$page_next=$_REQUEST['page']+1;$page_prev=$_REQUEST['page']-1;}
	if($page>=3){$page_min=$page-1;}else{$page_min=1;}
	$page_max=$page+1;
	$rs=$this->cn->query("select * from ".$this->t);
	$max_item=50;
	$sum_item=$rs->num_rows; 
	$sum_page=ceil($sum_item/$max_item);
	if(($page+1)>=$sum_page){$page_max=$sum_page;$page_next=null;}else{$page_max=$page_min+2;}
	$limit=($page-1)*$max_item;
	$limit=$limit.",".$max_item;
	$cari="";
	
	if(isset($_REQUEST['cari'])){$cari=" where $_REQUEST[field] LIKE '%".$_REQUEST['cari']."%'";}
		$rs=$this->cn->query("select * from ".$this->t." $cari limit $limit ");		
		$nf=$rs->field_count;
		echo "<p><div class='float-left'><a class='btn btn-success' href='".$this->p."/table/".$this->t."/action/create'><i class='fa fa-plus-square'></i></a> <a class='btn btn-warning' href='".$this->p."/table/".$this->t."/action/report'><i class='fa fa-print'></i></a></div><div class='float-right'><form class='form-inline' action='".$this->p."/table/".$this->t."' method=post><input type=text name=cari class='form-control mr-1'><input type=hidden name='field' value='".$rs->fetch_field_direct(1)->name."'><input class='btn btn-info' type=submit value='cari'></form></div></p>";
		echo "<br>";
		echo "<div class='table-responsive'><table class='table table-striped table-bordered table-hover mt-2'><tr>";
		echo "<th>Action</th>";
		for($i=0;$i<$nf;$i++){
				$name=$rs->fetch_field_direct($i)->name;
                $ftype=$rs->fetch_field_direct($i)->type;
                $flg=$rs->fetch_field_direct($i)->flags;
				if(substr($name,0,3)=='id_' && $i>0){
					echo "<th>".substr($name,3)."</th>";
				}
				else{
					echo "<th>".ucwords(str_replace("_"," ",$name))."</th>";	
				}
				
			}
		echo "</tr>";	 
		while($r=$rs->fetch_array()){
			echo "<tr>";
			echo "<td><a class='btn btn-primary' href='".$this->p."/table/".$this->t."/action/edit/id/".$r[0]."'><i class='fa fa-file'></i></a><a class='btn btn-danger' href='".$this->p."/table/".$this->t."/action/del/id/".$r[0]."'><i class='fa fa-trash fa-sm'></i></a></td>";
			for($i=0;$i<$nf;$i++){
				$name=$rs->fetch_field_direct($i)->name;
				$tp=$rs->fetch_field_direct($i)->type;
				$fl=$rs->fetch_field_direct($i)->flags;
				echo "<td>";
					switch($tp){
						case 3:
							if(substr($name,0,3)=='id_'&&$i>0){
								$rsx=$this->cn->query("select * from ".substr($name,3)." where $name='".$r[$i]."'");while($rx=mysqli_Fetch_array($rsx)){echo $rx[1];}
							}else{
						echo $r[$i];
						}
					break;						
						case 252:
							if($fl==144||$fl==4241){
								echo "<img src='data:image/jpg;base64,".base64_encode($r[$i])."' width=150>";
							}
							else{
								echo $r[$i];
							}
							break;
						default:
							echo $r[$i];
						break;
					}
				echo "</td>";
				}
				echo "</tr>";
		}
		echo "</table></div>";	
				echo "
					<ul class='pagination'>
					<li class='page-item ";if($page_prev==null){echo " disabled";}echo "'>";if($page_prev==null){echo "<a class='page-link' href='#'>Prev</a>";}else{echo "<a class='page-link' href='".$this->p."/table/".$this->t."/page/$page_prev'>Prev</a>";}echo "</li>";
					for($i=$page_min;$i<=$page_max;$i++){		
						echo "<li class='page-item";if($page==$i){echo "  active";}echo "'><a class='page-link' href='".$this->p."/table/".$this->t."/page/$i'>$i</a></li>";
					}
				echo "<li class='page-item";if($page_next==null){echo " disabled";}echo "'>";if($page_next==null){echo "<a class='page-link' href=''>Next</a>";}else{echo "<a class='page-link' href='".$this->p."/table/".$this->t."/page/$page_next'>Next</a>";}echo "</li>
				</ul><br>";
				
		
	}
	function report(){
		echo "<h2 class='text-center'>".strtoupper(str_replace("_"," / ",$this->t))."</h2>";
		$rs=$this->cn->query("select * from ".$this->t);		
		$nf=$rs->field_count;
		
		echo "<div class='table-responsive'  id=report><table class='table table-striped table-bordered table-hover'><tr>";
		for($i=0;$i<$nf;$i++){
				$name=$rs->fetch_field_direct($i)->name;
                $ftype=$rs->fetch_field_direct($i)->type;
                $flg=$rs->fetch_field_direct($i)->flags;
				if(substr($name,0,3)=='id_' && $i>0){
					echo "<th>".substr($name,3)."</th>";
				}else{
				echo "<th>".ucwords(str_replace("_"," ",$name))."</th>";	
				}
				
			}
		echo "</tr>";	 
		while($r=$rs->fetch_array()){
			echo "<tr>";
			for($i=0;$i<$nf;$i++){
				$name=$rs->fetch_field_direct($i)->name;
				$tp=$rs->fetch_field_direct($i)->type;
				$fl=$rs->fetch_field_direct($i)->flags;
				echo "<td>";
					switch($tp){
						case 3:
							if(substr($name,0,3)=='id_'&&$i>0){
								$rsx=$this->cn->query("select * from ".substr($name,3)." where $name='".$r[$i]."'");while($rx=mysqli_Fetch_array($rsx)){echo $rx[1];}
							}else{
						echo $r[$i];
						}
					break;						
						case 252:
							if($fl==144||$fl==4241){
								echo "<img src='data:image/jpg;base64,".base64_encode($r[$i])."' width=150>";
							}
							else{
								echo $r[$i];
							}
							break;
						default:
							echo $r[$i];
						break;
					}
				echo "</td>";
				}
				echo "</tr>";
		}
		echo "</table></div>";	
	
				
			
	}

	function auth($in_username,$in_password,$in_level){
		$state=false;
		$sql="SELECT * from $in_level WHERE username='$in_username' and password='$in_password'";
		$rs=$this->cn->query($sql);
		if($rs->num_rows>0){
			while($r=$rs->fetch_array()){
			    $_SESSION['username']=$r['username'];
				$_SESSION['level']=$in_level;
				$_SESSION['id']=$r[0];
				$_SESSION['nama']=$r[1];				
			}
			$state=true;
		}
		return $state;
	}
	
	function login(){
		?>
		
		<div class="hold-transition login-page">
			<div class="login-box">
				<div class="login-logo">
					<img src="<?php echo $this->p;?>/favicon.png" width='256px'>
				</div>
				<div class="card">
					<div class="card-body login-card-body">
						<p class="login-box-msg text-center"><?php echo $this->a;?></p>
						<form action="<?php echo $this->p;?>/action/login" method="post">
							<div class="input-group mb-3">
								<input type="text" name="username" class="form-control" placeholder="Username">
								<div class="input-group-append">
									<div class="input-group-text">
										<span class="fas fa-user"></span>
									</div>
								</div>
							</div>
							<div class="input-group mb-3">
								<input type="password" name="password" class="form-control" placeholder="Password">
								<div class="input-group-append">
									<div class="input-group-text">
										<span class="fas fa-lock"></span>
									</div>
								</div>
							</div>
							<div class="input-group mb-3">
								<select class="form-control" name="level">
									<option value='admin'>Admin</option>
									<option value='kasir'>Kasir</option>
								</select>
								<div class="input-group-append">
									<div class="input-group-text">
										<span class="fas fa-user-lock"></span>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-8"></div>
								<div class="col-4">
									<button type="submit" class="btn btn-primary btn-block"  name="goLogin" value="Log in">Login</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		
		<?php		
	}
	function logout(){
		session_destroy();
		$this->login();
		echo "<script>alert('Anda Berhasil Logout!');self.location='".str_replace("/admin","",$this->p)."/action/login'</script>";
	}
	function statistik($t){
		$rs=$this->cn->query("select * from $t");
		return $rs->num_rows;
	}
	function dashboard(){
		?>
		<!-- Content Header (Page header) -->
		<div class="content-header">
		  <div class="container-fluid">
			<div class="row mb-2">
			  <div class="col-sm-12">
				<h1 class="m-0 text-dark">Dashboard</h1>
			  </div><!-- /.col -->
			  
			</div><!-- /.row -->
		  </div><!-- /.container-fluid -->
		</div>
		<!-- /.content-header -->
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-3">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?php echo $this->statistik("admin");?></h3>

                <p>Admin</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="<?php echo $this->p;?>/table/admin" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-3">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?php echo $this->statistik("barang");?><sup style="font-size: 20px"></sup></h3>

                <p>barang</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="<?php echo $this->p;?>/table/barang" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-3">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?php echo $this->statistik("penjualan");?><sup style="font-size: 20px"></sup></h3>

				<p>Penjualan</p>
              </div>
              <div class="icon">
                <i class="small-box bg-success"></i>
              </div>
              <a href="<?php echo $this->p;?>/table/penjualan" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>         
          <!-- ./col -->
		            <!-- ./col -->
          <div class="col-lg-3 col-3">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><?php echo $this->statistik("detail");?><sup style="font-size: 20px"></sup></h3>

                <p>Detail</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="<?php echo $this->p;?>/table/detail" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>         
          <!-- ./col -->
        </div>
        <!-- /.row -->
		<?php
	}
	

	function kop(){
		echo "<div class='row'>
		<div class='col-2'><img src='".$this->p."/favicon.png' width='100px'></div><div class='col-10 text-center'><h4>".$this->a."</h4></div>
		</div>";
	}
	function ttd(){
		echo "<table><tr><td width='50%'></td><td width='50%'></td></tr></table>";
	}
	function penjualan(){
		if(isset($_REQUEST['mode'])){
			
			$this->cn->query("insert into penjualan values(null,'$_REQUEST[nama_pelanggan]','$_SESSION[id]','".date('Y-m-d',strtotime($_REQUEST['tanggal']))."')");
			$rs=$this->cn->query("select * from penjualan where nama_pelanggan='$_REQUEST[nama_pelanggan]' order by id_penjualan desc limit 1");
			while($r=$rs->fetch_array()){$idp=$r[0];}
			$id_barang=$_REQUEST['id_barang'];
			$harga=$_REQUEST['harga'];
			$jumlah=$_REQUEST['jumlah'];
			for($i=0;$i<count($id_barang);$i++){
				if($id_barang[$i]!="--Pilih--"){
				$this->cn->query("insert into detail values(null,'$idp','".$id_barang[$i]."','".$harga[$i]."','".$jumlah[$i]."')");
				}
			}
			echo "<div id=cetak>";
			echo "<h2 class='text-center'>Penjualan</h2>";
			echo "<table class=table>";
			echo "<tr><th colspan=2>$idp : ".$_REQUEST['nama_pelanggan']."</th><th>".date('Y-m-d H:i:s')."</th></tr>";
			echo "<tr><th>barang</th><th>Harga</th><th>Jumlah</th><th>Subtotal</th></tr>";
			$total=0;
			for($i=0;$i<count($id_barang);$i++){
				if($id_barang[$i]!="--Pilih--"){
				echo "<tr><td>".$this->id2nama("barang",$id_barang[$i])."</td><td>".$harga[$i]."</td><td>".$jumlah[$i]."</td><td>".($jumlah[$i]*$harga[$i])."</td></tr>";
				$total+=$jumlah[$i]*$harga[$i];}
			}
			echo "<tr><th colspan=3>Total</th><th>$total</th></tr>";
			echo "<tr><th colspan=3>Bayar</th><th>$_REQUEST[bayar]</th></tr>";
			echo "<tr><th colspan=3>Kembali</th><th>".($_REQUEST['bayar']-$total)."</th></tr>";
			echo "</table>";
			echo "</div>";
			?>
			<script>
			function cetak(){
				var ori=document.body.innerHTML;
	            var ctk=document.getElementById('cetak').innerHTML;
	            document.body.innerHTML=ctk;
	            window.print();
	            document.body.innerHTML=ori;
			}
			cetak();
			</script>
			<?php
			
		}
		else{
		?>
				
				<form action='<?php echo $this->p;?>/action/penjualan' method='post' enctype='multipart/form-data'><input type=hidden name=mode value='simpan'>
				<div class='form-group row'>
						<label for='tanggal' class='col-sm-2 col-form-label'>Tanggal</label>
						<div class='col-sm-10'>
							<input type='date' class='form-control' id='tanggal' placeholder='tanggal' name='tanggal' required>
						</div>
				</div>
				<div class='form-group row'>
						<label for='keterangan' class='col-sm-2 col-form-label'>Pelanggan</label>
						<div class='col-sm-10'>
							<input type=text class='form-control' name='nama_pelanggan' placeholder="Nama Pelanggan">
						</div>
					</div>
					
					<div class='table-responsive'>
					<table id="example2" class="table table-bordered table-hover">
					<tr class='text-center'>
						<thead><th>No</th><th>barang</th><th>Jumlah</th><th>Harga</th><th>Subtotal</th>
					</tr></thead>
					<tbody>
					<?php
					for($i=1;$i<=10;$i++){
					echo "
					<tr>
						<td class='text-center'>$i</td><td><select class='form-control' name='id_barang[]' id='id_barang$i'><option>--Pilih--</option>";		
						
						
						$rs=$this->cn->query("select * from barang where jumlah>0 order by tanggal ASC");
								$cur_barang="";
								while($r=$rs->fetch_array()){
									if($cur_barang!=$r[1]){
									echo "<option value='$r[0]'>$r[1] ($r[3]) $r[jumlah]</option>";}
										$cur_barang=$r[1];
									}
							
							echo "</select></td><td class='text-right'><input type='text' class='form-control' value='0' id='jumlah$i' placeholder='masuk' name='jumlah[]'></td><td><input class='form-control' type=text value='0' id='harga$i' name='harga[]'></td><td><input type=text class='form-control' value='0' id='subtotal$i' disabled></span></td>
					</tr>";
					}
					?>
					</tbody>
					<tr class='text-right'><td colspan=4><b>Total</b></td><td><input class='form-control' type=text value='0' name=total id=total disabled></td></tr>
					<tr class='text-right'><td colspan=4><b>Bayar</b></td><td><input class='form-control' type=text value='0' name=bayar id=bayar></td></tr>
					<tr class='text-right'><td colspan=4><b>Kembali</b></td><td><input class='form-control' type=text value='0' name=kembali id=kembali disabled></td></tr>
					</table>
					</div>
					
							<input type=submit class='btn btn-primary' value=Simpan> &nbsp <input type=reset class='btn btn-warning' value=Reset>
					
				</form>
				<script src="<?php echo $this->p;?>/assets/AdminLTE-3.0.5/plugins/jquery/jquery.min.js"></script>
				<script>
					
					$(document).ready(function(){
						<?php
							for($i=1;$i<=10;$i++){
								echo "\$('#jumlah$i').keyup(function(){\$('#subtotal$i').val(parseInt(\$('#jumlah$i').val())*parseInt(\$('#harga$i').val()));\$('#total').val(parseInt(\$('#subtotal1').val())+parseInt(\$('#subtotal2').val())+parseInt(\$('#subtotal3').val())+parseInt(\$('#subtotal4').val())+parseInt(\$('#subtotal5').val())+parseInt(\$('#subtotal6').val())+parseInt(\$('#subtotal7').val())+parseInt(\$('#subtotal8').val())+parseInt(\$('#subtotal9').val())+parseInt(\$('#subtotal10').val()));});";
								echo "\$('#id_barang$i').change(function(){var harga = \$('#id_barang$i option:selected').html();harga=harga.split('(');harga=harga[1].replace(')','');harga=harga.split(' ');\$('#harga$i').val(harga[0]);});";
								echo "\$('#bayar').keyup(function(){\$('#kembali').val(parseInt(\$('#bayar').val())-parseInt(\$('#total').val()));});";
							}
						?>

					});
		
					
				</script>
				<?php
		}
	}
	
	function laporan(){
		echo "
	            <script>
	                function cetak(){
	                    var ori=document.body.innerHTML;
	                    var ctk=document.getElementById('cetak').innerHTML;
	                    document.body.innerHTML=ctk;
	                    window.print();
	                    document.body.innerHTML=ori;
	                }
	            </script>";
	            
	            
		echo "<form action='".$this->p."/action/laporan' method=post>";
		echo "<div class='form-group row'>
				<label for='tanggal' class='col-sm-2 col-form-label'>Tanggal</label>
				<div class='col-sm-5'>
					<input type='date' class='form-control' id='tanggal' placeholder='tanggal' name='mulai' required>
				</div>
				<div class='col-sm-5'>
					<input type='date' class='form-control' id='tanggal' placeholder='tanggal' name='sampai' required>
				</div>
		</div>";

		echo "<div class='form-group row'>
				<label for='tanggal' class='col-sm-2 col-form-label'></label>
				<div class='col-sm-10'>
					<input type=submit value='pilih' class='btn btn-primary'>
				</div>
				
		</div>";
		
		
					
					
					
		
		echo "</form><div class='mb-1'></div>";
		if(isset($_REQUEST['mulai'])&&isset($_REQUEST['sampai'])){
			$rs=$this->cn->query("select * from penjualan p inner join detail d on p.id_penjualan=d.id_penjualan where (p.tanggal between '$_REQUEST[mulai]' and '$_REQUEST[sampai]')");		
		}
		else{
		$rs=$this->cn->query("select * from penjualan p inner join detail d on p.id_penjualan=d.id_penjualan where month(tanggal)=".date('m'));		
		}
		echo "<div id=cetak>";
		$this->kop();
		echo "<h2 class='text-center'>LAPORAN PENJUALAN</h2>";
		echo "<div class='table-responsive'><table class='table table-striped table-bordered table-sm table-hover'>";
		echo "<tr class='text-center'><th>No</th><th>Nama Pelanggan</th><th>nama_barang</th><th>jumlah</th><th>harga</th><th>subtotal</th></tr>";
		$no=1;$total=0;
		while($r=$rs->fetch_array()){
			echo "<tr><td class='text-center'>$no</td><td>$r[nama_pelanggan]</td><td>".$this->id2nama("barang",$r['id_barang'])."</td><td>$r[jumlah]</td><td>$r[harga]</td><td>".($r['jumlah']*$r['harga'])."</td></tr>";$no++;
			$total+=$r['jumlah']*$r['harga'];
		}
		echo "<tr class='text-right'><td colspan=5><b>Total</b></td><td>$total</td></tr>";
		echo "</table>";
		echo "</div></div><hr><button class='btn btn-primary' onclick='cetak();'><i class='fa fa-print'></i></button><br>";
	}
	function id2nama($t,$i){
		$hasil="";
		$rs=$this->cn->query("select * from $t where id_$t=$i");
		while($r=$rs->fetch_array()){
			$hasil=$r[1];
		}
		return $hasil;
	}

}
?>