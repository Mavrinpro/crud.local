<?php 

/**
 * summary
 */
class Names
{
	public $tre = 15;
	public $user;
	public $name;

	function __construct($user='Fred', $names='jfjkfyukfyuk', $tre=7){
		$this->user = $user ;
		$this->name = $names;
		$this->tre =  $tre;

	}

    public function View()
    {
        echo '<pre>';
        var_dump($this->user, $this->name, $this->tre);
        echo '</pre>';
    }
}

$prod = new Names($tr=54);
$prod->View();

/**
 * summary
 */
class ValidateInputs 
{

    public function __construct()
    {
        
    }
}
$str = 'Привет';
$str = iconv_strlen($str);
echo $str;


