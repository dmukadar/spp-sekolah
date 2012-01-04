<?php

/**
 * Very simple model generator for used in CI
 *
 * @author Rio Astamal <me@rioastamal.net>
 */
$class = '';
$_fields = '';
$ci_model = '';
$table_name = '';
$primary_key = '';
$classname = '';
$classfile = '';

$db = array();
$db['host'] = 'localhost';
$db['user'] = '';
$db['pass'] = '';
$db['name'] = '';

function assign_result() {
	global $class, $ci_model, $table_name, $primary_key, $db, $classname, $classfile;
	
	$db['host'] = $_POST['db_host'];
	$db['user'] = $_POST['db_user'];
	$db['pass'] = $_POST['db_pass'];
	$db['name'] = $_POST['db_name'];
	
	// connect ke mysql untuk mendapatkan daftar field
	$conn = @mysql_connect($db['host'], $db['user'], $db['pass']);
	if (!$conn) {
		echo ("ERROR: Gagal melakukan koneksi ke Database! Pastikan username dan Password benar.");
		return FALSE;
	}
	if (!mysql_select_db($db['name'])) {
		echo ("ERROR: Gagal melakukan koneksi ke Database! Pastikan nama database benar.");
		return FALSE;
	}
	
	// $fields = $_POST['fieldsname'];
	$classname = trim($_POST['classname']);
	$classname_lower = strtolower($classname);
	$konstanta = strtoupper($classname) . '_TABLE';
	$table_name = trim($_POST['tablename']);
	$tab_name = $table_name;
	
	if (!$table_name) {
		$tab_name = $classname_lower;
	}
	
	$query = mysql_query("SHOW COLUMNS FROM {$table_name}");
	if (!$query) {
		echo ("ERROR: Gagal mendapatkan field dari tabel {$table_name}. " . mysql_error());
		return FALSE;
	}
	$fields = array();
	while ($row = mysql_fetch_object($query)) {
		$fields[] = $row->Field;
		if ($row->Key == 'PRI') {
			$primary_key = $row->Field;
		}
	}
	
	$primary_key = (trim($_POST['primarykey'] ? trim($_POST['primarykey']) : $primary_key));

	$classfile = ': ' . $classname_lower . '_model.php';
	$class = "";
	
	if (get_magic_quotes_gpc()) {
		$fields = stripslashes($fields);
		$classname = stripslashes($classname);
	}

	$class = "&lt;?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');\n\n";
	$class .= "define('{$konstanta}', '{$tab_name}');\n\n";
	$class .= "class " . $classname . " {\n";
	
	// attribute
	foreach ($fields as $field) {
		$field = trim($field);
		$class .= "\tprivate \${$field} = NULL;\n";
	}
	
	$class .= "\n";
	
	// constructor
	$class .= "\tpublic function __construct() {\n";
	$class .= "\t}\n\n";
	
	// method
	foreach ($fields as $field) {
		$field = trim($field);
		
		// setter
		$class .= "\tpublic function set_{$field}(\${$field}) {\n";
		$class .= "\t\t\$this->{$field} = \${$field};\n";
		$class .= "\t}\n\n";
		
		$class .= "\tpublic function get_{$field}() {\n";
		$class .= "\t\treturn \$this->{$field};\n";
		$class .= "\t}\n\n";
	}
	
	$class .= <<<EOF
	/**
	 * Method untuk melakukan mapping dari standard object ke {$classname_lower}.
	 * Cara yang lebih efektif sebenarnya adalah dengan memodifikasi 
	 * internal Database Driver nya CI.
	 *
	 * @author Rio Astamal <me@rioastamal.net>
	 *
	 * @param array \$array_of_object - Array hasil query
	 * @return array - Array of \$class
	 */
	public static function import_from_array(\$array_of_object) {
		\$objects = array();
		foreach (\$array_of_object as \$i => \$result) {
			\$tmp = new {$classname}();

EOF;
	
	foreach ($fields as $field) {
		$field = trim($field);
		$class .= "\t\t\t\$tmp->set_{$field}(\$result->{$field});\n";
	}
	
	$class .= <<<EOF
			\$objects[\$i] = clone \$tmp;
		}
		
		\$tmp = NULL;
		
		return \$objects;
	}
	
	/**
	 * Method untuk mengexport isi dari object ke dalam type 
	 * associative array atau object.
	 *
	 * @author Rio Astamal <me@rioastamal.net>
	 *
	 * @param string \$export_type - Tipe data yang akan diexport
	 * @param array \$param_exclude - Daftar attribut yang akan diexclude (akan ditambahkan dengan \$def_exclude)
	 * @return void
	 */
	public function export(\$export_type='array', \$param_exclude=array()) {
		\$result = NULL;
		
		// properti yang akan diexclude dalam hasil
		// sehingga tidak digunakan pada saat akan insert atau update
		\$def_exclude = array(
		);
		\$exclude = \$def_exclude + \$param_exclude;
		
		// export dengan tipe array
		if (\$export_type === 'array') {
			\$result = array();
			foreach (\$this as \$attr => \$val) {
				if (!in_array(\$attr, \$exclude)) {
					// properti tidak termasuk dalam daftar exclude jadi
					// masukkan ke hasil
					\$result[\$attr] = \$val;
				}
			}
			return \$result;
		}
		
		// export dengan tipe standard object
		if (\$export_type === 'object') {
			\$result = new stdClass();
			foreach (\$this as \$attr => \$val) {
				if (!in_array(\$attr, \$exclude)) {
					// properti tidak termasuk dalam daftar exclude jadi
					// masukkan ke hasil
					\$result->\$attr = \$val;
				}
			}
			return \$result;
		}
		
		// seharusnya tidak sampai disini jika parameter yang diberikan benar
		throw new Exception('Sepertinya argumen yang anda berikan pada method $classname::export tidak benar.');
	}

EOF;
	
	$class .= "}\n";
	
	$ci_model =<<< EOF
	
// --- CI Model ---
class {$classname}_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}
	
	public function get_all_{$classname_lower}(\$where=array(), \$limit=-1, \$offset=0) {
		if (\$limit > 0) {
			\$this->db->limit(\$limit, \$offset);
		}
		if (\$where) {
			\$this->db->where(\$where);
		}
		\$query = \$this->db->get({$konstanta});
		if (\$query->num_rows == 0) {
			throw new {$classname}NotFoundException ("Record tidak ditemukan.");
		}
		
		\$result = \$query->result();
		
		return {$classname}::import_from_array(\$result);
	}
	
	public function get_single_{$classname_lower}(\$where=array()) {
		\$record = \$this->get_all_{$classname_lower}(\$where, 1, 0);
			
		return \$record[0];
	}
	
	public function insert(\${$classname_lower}) {
		if (FALSE === (\${$classname_lower} instanceof $classname)) {
			throw new Exception('Argumen yang diberikan untuk method {$classname}_model::insert harus berupa instance dari object $classname.');
		}
		
		\$data = \${$classname_lower}->export();
		\$this->db->insert({$konstanta}, \$data);
		
		if (\$this->db->affected_rows() == 0) {
			throw new Exception(sprintf('Gagal memasukkan data {$classname_lower}.'));
		}
	}
	
	public function update(\${$classname_lower}, \$exclude=array()) {
		if (FALSE === (\${$classname_lower} instanceof {$classname})) {
			throw new Exception('Argumen yang diberikan untuk method {$classname}_model::update harus berupa instance dari object $classname.');
		}
		
		\$data = \${$classname_lower}->export('array', \$exclude);
EOF;
		if ($primary_key) :
			$ci_model .= <<<EOF

		\$where = array('{$primary_key}' => \${$classname_lower}->get_{$primary_key}());
EOF;
		else :
			$ci_model .= <<<EOF


		// GANTI SAYA? TENTUKAN PRIMARY KEY-NYA 
		// \$where = array('{$classname_lower}_id' => \${$classname_lower}->get_{$classname_lower}_id());
EOF;
		endif;
		
		$ci_model .= <<<EOF

		\$this->db->where(\$where);
		\$this->db->update({$konstanta}, \$data);
		
		if (\$this->db->affected_rows() == 0) {
			// do nothing
		}
	}
	
	public function custom_update(\$where, \$data) {
		\$this->db->where(\$where);
		\$this->db->update({$konstanta}, \$data);
	}
	
	public function delete(\${$classname_lower}) {
		if (FALSE === (\${$classname_lower} instanceof $classname)) {
			throw new Exception('Argumen yang diberikan untuk method {$classname_lower}_model::insert harus berupa instance dari object {$classname}.');
		}
		
EOF;
		if ($primary_key) :
			$ci_model .= <<<EOF

		\$where = array('{$primary_key}' => \${$classname_lower}->get_{$primary_key}());
EOF;
		else :
			$ci_model .= <<<EOF

		// GANTI SAYA? TENTUKAN PRIMARY KEY-NYA 
		// \$where = array('{$classname_lower}_id' => \${$classname_lower}->get_{$classname_lower}_id());
EOF;
		endif;
		
		$ci_model .= <<<EOF

		\$this->db->delete({$konstanta}, \$where);
		
		if (\$this->db->affected_rows() == 0) {
			// do nothing
		}
	}
	
	public function custom_delete(\$where) {
		\$this->db->delete({$konstanta}, \$where);
	}
}


class {$classname}NotFoundException extends Exception {
	public function __construct(\$mesg, \$code=101) {
		parent::__construct(\$mesg, \$code);
	}
}

EOF;
	
}

if (isset($_POST['submit'])) {
	assign_result();
}

?><html>
<head>
<style type="text/css">
	.code {
		background: #f1f1f1;
		padding: 4px;
	}
</style>
</head>
<body>
	<form action="#class" method="post">
		<h2>Data Koneksi Database</h2>
		<label>DB Host *</label>: 
		<input type="text" name="db_host" id="db_host" value="<?php echo htmlentities(@$db['host']);?>" /><br/>
		<label>DB User *</label>: 
		<input type="text" name="db_user" id="db_user" value="<?php echo htmlentities(@$db['user']);?>" /><br/>
		<label>DB Password *</label>: 
		<input type="text" name="db_pass" id="db_pass" value="<?php echo htmlentities(@$db['pass']);?>" /><br/>
		<label>DB Name *</label>: 
		<input type="text" name="db_name" id="db_name" value="<?php echo htmlentities(@$db['name']);?>" /><br/>
		<br/ >
		<h3>Informasi Model</h3>
		<label>CLASS NAME *</label>: 
		<input type="text" name="classname" id="classname" value="<?php echo htmlentities(@$classname);?>" /><br/>
		<label>TABLE NAME *</label>: 
		<input type="text" name="tablename" id="tablename" value="<?php echo htmlentities(@$table_name);?>" /><br/>
		<label>PRIMARY KEY</label>: 
		<input type="text" name="primarykey" id="primarykey" value="<?php echo htmlentities(@$primary_key);?>" /><br/>
		<br/>
		<input type="submit" name="submit" id="submit" value="GENERATE" />
	</form>
	<a name="class"></a>
	<h2>Class <?php echo ($classfile);?></h2>
	<pre class="code" id="result"><?php echo ($class); ?>

<?php echo ($ci_model); ?></pre>

	<script type="text/javascript">
	 function selectText() {
		  if (document.selection) {
		  var range = document.body.createTextRange();
				range.moveToElementText(document.getElementById('result'));
		  range.select();
		  }
		  else if (window.getSelection) {
		  var range = document.createRange();
		  range.selectNode(document.getElementById('result'));
		  window.getSelection().addRange(range);
		  }
	 }
	 
	 document.getElementById('result').onclick = selectText;
	 </script>
</body>
<html>
