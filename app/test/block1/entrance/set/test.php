<script type="text/javascript" src="../plugin/jquery.min.js"></script>
<?php
$myfile = fopen("word.txt", "r") or die("Unable to open file!");

// Output one character until end-of-file
       
$str = "";
while(!feof($myfile)) {
  $str.=fgetc($myfile);
}
fclose($myfile);
$str = str_replace("\r\n","$",$str);

class FormElementMaker{
	 /*
	 public $bar;
    public function __get($name) {

        echo "Get:$name";
        return $this->$name;
    }

    public function __set($name, $value) {

        echo "Set:$name to $value";
        $this->$name = $value;
    }
	*/
		public function Text($name = NULL,$id = NULL,$class = NULL,$value = NULL){
			$name = (is_null($name)) ? '' : "name='".$name."'";
			$id = (is_null($id)) ? '' : "id='".$id."'";
			$class = (is_null($class)) ? '' : "class='".$class."'";
			$value = (is_null($value)) ? '' : "value='".$value."'";
			$element = ("<input {$name} {$id} {$class} type='text' {$value} > ");
			print($element);
		}
		public function checkbox($name = NULL,$id = NULL,$class = NULL,$label = NULL,$selected = 'false'){
			$name = (is_null($name)) ? '' : "name='".$name."'";
			$id = (is_null($id)) ? '' : "id='".$id."'";
			$class = (is_null($class)) ? '' : "class='".$class."'";
			$label = (is_null($label)) ? '' : $label;
			$selected = ($selected == 'false') ? '' : "checked='checked'";
			$element = ("<label><input {$name} {$id} {$class} type='checkbox' {$selected} />{$label}</label>");
			print($element);
		}
		public function hidden($name = NULL,$id = NULL,$class = NULL,$value = NULL){
			$name = (is_null($name)) ? '' : "name='".$name."'";
			$id = (is_null($id)) ? '' : "id='".$id."'";
			$class = (is_null($class)) ? '' : "class='".$class."'";
			$value = (is_null($value)) ? '' : "value='".$value."'";
			$element = print("<input {$name} {$id} {$class} type='hidden' checked='' {$value} > ");
			print($element);
		}
		public function select($name = NULL,$id = NULL,$class = NULL,$option = NULL,$selectedId = NULL){
			$name = (is_null($name)) ? '' : "name='".$name."'";
			$id = (is_null($id)) ? '' : "id='".$id."'";
			$class = (is_null($class)) ? '' : "class='".$class."'";
			//$selectedId = (is_null($selectedId)) ? '' : "default=";
			if(is_null($option)){
				$option = '<option>輸入資料</option>';	
			}else{
				//print_r($option->val);
				$option_str = '';
				foreach(($option->val) as $k => $val){
					if($selectedId == $option->val[$k]){//selected
						$option_str .= "<option value='{$option->val[$k]}' selected='selected'>{$option->text[$k]}</option>";	
					}else{
						$option_str .= "<option value='{$option->val[$k]}'>{$option->text[$k]}</option>";	
						//$selectedId 
					}
					
				}
			}
			$element = "<select {$name} {$id} {$class} >{$option_str}</select>";
			print($element);
		}
	}
	echo '<br>';
	$input_m1 = new FormElementMaker;
	$data = explode('@@',$str);//資料來哩
	$data_col = 6;//資料列數 name,url,lon,lat,type,enable(bool)
	foreach($data as $k=> $val){
		$col_type = $k%$data_col;
		switch($col_type){
			case 0://name
			$input_m1->Text('name[]',NULL,'name',$val);
			break;
			case 1://ref
			$input_m1->Text('href[]',NULL,'url',$val);
			break;
			case 2://lon
			$input_m1->Text('lon[]',NULL,'lon',$val);
			break;
			case 3://lat
			$input_m1->Text('lat[]',NULL,'lat',$val);
			break;
			case 4://type
				$option = new stdClass();
				$option->val = array('0','1','2');
				$option->text = array('未分類','機場','雷達');
				$input_m1->select(NULL,NULL,NULL,$option,$val);
				echo $val;
			break;
			case 5://enable(bool)
				$input_m1->checkbox('enable[]',NULL,NULL,"開啟",$val);
				echo "<br>";
			break;
		}
		//echo $val;
	}

	?>

<style> 
.container{
	border:gray;
}
input[type=text] {
    padding: 2px 2px;
    margin: 1px 0;
    box-sizing: border-box;
	font-size:1.2em;
}
select{
    padding: 2px 2px;
    margin: 1px 0;
    box-sizing: border-box;
	font-size:1.2em;
}
.name{
	width:10%;
}
.url{
	width:45%;
}
.lat{
    width:10%;
}
.lon{
    width:10%;
}
.a{
	width: 30%;
}
.b{
	width: 45%;
}
.add_input{
	background-color:#ffffb3;
}
</style>
</div>
<!--<input type="button" value="v" class="add" id="preview" />
<input type="button" value="v" class="add" id="re-preview" />-->
<form id='form'>
<div id='container' class='container'>
</div>
</form>
<hr>
<input type="button" value="新增欄位" class="add" id="add" />
<hr>
<input type="button" value="儲存" class="test" id="test" />
<!--<input type="button" value="儲存" class="save" id="save" />-->
<input type="button" value="取消" class="cancel" id="cancel" />
<hr>
<a href='../../index.php'>前往Menu</a>
	
<script>
$(document).ready(function() {
	var json = '<?php echo json_encode(explode('@@',$str));?>';
	input_build(JSON.parse(json));
	function input_build(data){
		var cnt=1;
		for(key in data){
			if(cnt%6==0){//enable
				if(data[key]=='true'){
					$('#container').append("<label class='container'><input name='enable[]' type='checkbox' checked=''><span class='checkmark'></span>開放</label>");
					$('#container').append("<br>");
				}else{
					$('#container').append("<label class='container'><input name='enable[]' type='checkbox' ><span class='checkmark'></span>開放</label>");
					$('#container').append("<br>");
					
				}
			}else if(cnt%6==2){//href
				$('#container').append("<input class='url' type='text' name='href[]' value='"+data[key]+"'/>");
				//$('#container').append("<input type='button' value='刪除' class='del' id='del_"+cnt+"' />");
			}else if(cnt%6==3){//lon
				$('#container').append("<input class='lon' type='text' name='lon[]' value='"+data[key]+"'/>&nbsp;");
			}else if(cnt%6==4){//lat
				$('#container').append("<input class='lat' type='text' name='lat[]' value='"+data[key]+"'/>&nbsp;");
			}else if(cnt%6==5){//type
			//https://stackoverflow.com/questions/6601952/programmatically-create-select-list
				//$('#container').append("<input type='hidden' value=''><input class='name' type='text' name='name[]' class='a' value='"+data[key]+"'/>&nbsp;");
				var select =  $("<select>").appendTo("#container");
				var select_data = [
					{val : 0, text: '未定義'},
					{val : 1, text: '機場'},
					{val : 2, text: '雷達'}
					];
				 $(select_data).each(function() {
					if(this.val == data[key]){
						select.append($("<option>").attr('value',this.val).attr('selected',"selected").text(this.text));
					}else{
						select.append($("<option>").attr('value',this.val).text(this.text));	
					}
 
				});
				console.log(select);
				//<option value='1'>機場</option><option value='2'>雷達</option>
				//$('#container').append("<select><option value='1'>機場</option><option value='2'>雷達</option></select>");
				//$('select option[value="1"]').attr("selected",true);
			}
			else if(cnt%6==1){//name
				$('#container').append("<input type='hidden' value='X'>");
				$('#container').append("<input class='name' type='text' name='name[]' value='"+data[key]+"'/>&nbsp;");
			}else{
				alert('err');
			}
			cnt++;
		}
	}

	//ajax_text_write('名冊：456@@localhost/asd@@true');
	function ajax_text_write(data){
		console.log(data);
		
		var scriptUrl = "ajax_text_write.php";
		$.ajax({
			url: scriptUrl,
			type: 'post',
			data:{data:data},
			dataType: 'html',
			async: false,
			success: function(data) {
				result = data;
				},
			error: function(jqXHR, textStatus, errorThrown) {
			// report error
				console.log(errorThrown);
			}
			});		
		//alert(data);
			//alert(result);
			console.log(result);
			location.reload();
		}
	/*	$( "#save" ).on( "click", {
			data:$("#form").serializeArray()
		}, ajax_text_write );*/
		$( "#add" ).on( "click", function(){
			mk_new_input();
		});
		$( "#cancel" ).on( "click", function(){
			location.reload();
		});
		$( "#save" ).on( "click", function(){
			var data_str = '';
			$('#form').find('input').each(function(idx, elem){
			var element_col = 5+1;//一欄有幾個元素
			//var flag = true;
			console.log(idx+','+$(elem).val());
			//console.log($(elem).attr('type'));
			if(idx % element_col==0){//hidden 元素放第一個
				if($(elem).val()!==''){
					return true;
				}
			}
			else if($(elem).attr('type')=='button'){
				;
			}
			else if($(elem).attr('type')=='checkbox'){
				console.log('state:'+$(elem).is(':checked'));
				if($(elem).is(':checked')==true){
					data_str +='true'+'@@';
				}else{
					data_str +='false'+'@@';
				}
			}else{
				data_str += $(elem).val()+'@@';
			}
			
			
		});
		data_str = data_str.substring(0, data_str.length - 2); 
		console.log(data_str);
		ajax_text_write(data_str);
		//console.log($("#form").serializeArray());
	});		
	$( "input[id='test']" ).on( "click", function(){
			var data_str = '';
			console.log('test');
			$('#form').find(':input').each(function(idx, elem){
			var val;
			var element_col = 7;//一欄有幾個元素
			//var flag = true;
			//console.log(idx+','+$(elem).val());
			//console.log($(elem).attr('type'));
			if(idx % element_col==0){//hidden
				if($(elem).val()!==''){
					return true;
				}
				else{
					;
				}
			}else if(idx % element_col==5){//select
				//val = $(elem).children(":selected").attr("id");
				val = $(elem).children(":selected").val();
			//}else if(idx % element_col==2 || idx % element_col==3 || idx % element_col==4 || idx % element_col==6){//name,url,lat,lon
			}else if(idx % element_col==6){//enable
				val = ($(elem).is(':checked') == true) ? true : false;
			}else{//name,url,lat,lon
				val = $(elem).val();
			}
			//console.log(idx);
			//console.log($(elem).attr('type'));
			//console.log(val);
			data_str += val+'@@';
		});
		data_str = data_str.substring(0, data_str.length - 2); //去掉最後的「@@」
		console.log(data_str);
		ajax_text_write(data_str);
		/*
		data_str = data_str.substring(0, data_str.length - 2); 
		console.log(data_str);
		
		//console.log($("#form").serializeArray());
			var data_str = '';
			$('#form').find('input').each(function(idx, elem){
			console.log(idx+','+$(elem).val());
			//console.log($(elem).attr('type'));
			
			if($(elem).attr('type')=='checkbox'){
				console.log('state:'+$(elem).is(':checked'));
				if($(elem).is(':checked')==true){
					data_str += 'true'+'@@';
				}else{
					data_str += 'false'+'@@';
				}
			}else{
				data_str += $(elem).val()+'@@';
			}
			
			
		});
		data_str = data_str.substring(0, data_str.length - 2); 
		ajax_text_write(data_str);
		//console.log($("#form").serializeArray());
		*/
	});
	function mk_new_input(){
		$('#container').append("<input type='hidden' value='X'>");
		$('#container').append("<input type='text' name='name[]' class='name add_input' value=''/>&nbsp;");
		$('#container').append("<input type='text' name='href[]' class='url add_input'  value=''/>");
		$('#container').append("<input type='text' name='lon[]'  class='lon add_input' value=''/> ");
		$('#container').append("<input type='text' name='lat[]'  class='lat add_input' value=''/> ");
		
		var select =  $("<select>").appendTo("#container");
				var select_data = [
					{val : 0, text: '未定義'},
					{val : 1, text: '機場'},
					{val : 2, text: '雷達'}
					];
				 $(select_data).each(function() {
					select.append($("<option>").attr('value',this.val).text(this.text));	 
				});
		
		$('#container').append("<label class='container'><input name='enable[]' type='checkbox' checked=''><span class='checkmark'></span>開放</label>");
		$('#container').append("<br>");
	}
	//($("#form").serializeArray().map(function(v) {return [v.name, v.value];}))	
});

</script>


