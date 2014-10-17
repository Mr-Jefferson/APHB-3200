<?php
require_once(dirname(__FILE__) . '/../autorun.php');
require_once(dirname(__FILE__) . '/../web_tester.php');

class TestOfCits3200 extends WebTestCase {
    
    function testHomepage() {
		echo "<br>----------- LOGIN TEST -----------<br>";
		{
		echo "Testing login. - Incorrectly<br>";
        $this->get('http://128.199.218.6/APHB-3200/Library/Pages/Login.php');
		$this->setField('username', 'adminn');
		$this->setField('password', 'passwoord');
		$this->click('Login');
		$this->assertNoText('Proposal');
				
		echo "Testing login. - Correctly<br>";
        $this->get('http://128.199.218.6/APHB-3200/Library/Pages/Login.php');
		$this->setField('username', 'admin');
		$this->setField('password', 'password');
		$this->click('Login');
		$this->assertText('Proposal');
		}
		
	}
}
?>
		
