<?php
require_once(dirname(__FILE__) . '/../autorun.php');
require_once(dirname(__FILE__) . '/../web_tester.php');

class TestOfCits3200 extends WebTestCase {
    
    function testHomepage() {
		echo "<BR>----------- LOGIN TEST -----------<br>";
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
		
		echo "<br>----------- CALCULATIONS TEST -----------<br>";
		{
		echo "Adding more markers.<br>";
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Marker.php');
		$this->click('Add Marker');
		$this->setField('M_FN', 'Calculation');
		$this->setField('M_LN', 'tester');
		$this->clickSubmitById('Mcreate');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Marker.php?M_ID=2');
		$this->assertText('Calculation');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Marker.php');
		$this->click('Add Marker');
		$this->setField('M_FN', 'Calculator');
		$this->setField('M_LN', 'testman');
		$this->clickSubmitById('Mcreate');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Marker.php?M_ID=3');
		$this->assertText('Calculator');
		
		echo "Adding more students<br>";
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		$this->click('Add Student');
		$this->setField('S_SD', '21128099');
		$this->setField('S_FN', 'Luke');
		$this->setField('S_LN', 'Davis');
		$this->clickSubmitById('Screate');
		$this->assertText('21128099');
		$this->click('Add Student');
		$this->setField('S_SD', '21129911');
		$this->setField('S_FN', 'Arun');
		$this->setField('S_LN', 'Gimblett');
		$this->clickSubmitById('Screate');
		$this->assertText('21129911');
		
		echo "Adding Marks<br>";
		{
		
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/dEntry.php?S_ID=1&seminar=1');
		$this->setField('marks_marker', '2');
		$this->setField('mark_1', '9');
		$this->setField('mark_2', '3');
		$this->setField('mark_3', '6');
		$this->click('Add Marks');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/dEntry.php?S_ID=1&seminar=1');
		$this->setField('marks_marker', '3');
		$this->setField('mark_1', '5');
		$this->setField('mark_2', '5');
		$this->setField('mark_3', '8');
		$this->click('Add Marks');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/dEntry.php?S_ID=1&seminar=2');
		$this->setField('marks_marker', '1');
		$this->setField('mark_1', '5');
		$this->setField('mark_2', '1');
		$this->setField('mark_3', '2');
		$this->click('Add Marks');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/dEntry.php?S_ID=1&seminar=2');
		$this->setField('marks_marker', '2');
		$this->setField('mark_1', '6');
		$this->setField('mark_2', '7');
		$this->setField('mark_3', '4');
		$this->click('Add Marks');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/dEntry.php?S_ID=1&seminar=2');
		$this->setField('marks_marker', '3');
		$this->setField('mark_1', '3');
		$this->setField('mark_2', '2');
		$this->setField('mark_3', '6');
		$this->click('Add Marks');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		}
		{
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/dEntry.php?S_ID=2&seminar=1');
		$this->setField('marks_marker', '1');
		$this->setField('mark_1', '7');
		$this->setField('mark_2', '1');
		$this->setField('mark_3', '5');
		$this->click('Add Marks');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/dEntry.php?S_ID=2&seminar=1');
		$this->setField('marks_marker', '2');
		$this->setField('mark_1', '6');
		$this->setField('mark_2', '4');
		$this->setField('mark_3', '1');
		$this->click('Add Marks');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/dEntry.php?S_ID=2&seminar=1');
		$this->setField('marks_marker', '3');
		$this->setField('mark_1', '2');
		$this->setField('mark_2', '2');
		$this->setField('mark_3', '6');
		$this->click('Add Marks');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/dEntry.php?S_ID=2&seminar=2');
		$this->setField('marks_marker', '1');
		$this->setField('mark_1', '3');
		$this->setField('mark_2', '5');
		$this->setField('mark_3', '0');
		$this->click('Add Marks');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/dEntry.php?S_ID=2&seminar=2');
		$this->setField('marks_marker', '2');
		$this->setField('mark_1', '1');
		$this->setField('mark_2', '3');
		$this->setField('mark_3', '6');
		$this->click('Add Marks');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/dEntry.php?S_ID=2&seminar=2');
		$this->setField('marks_marker', '3');
		$this->setField('mark_1', '9');
		$this->setField('mark_2', '9');
		$this->setField('mark_3', '8');
		$this->click('Add Marks');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		}
		{
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/dEntry.php?S_ID=3&seminar=1');
		$this->setField('marks_marker', '1');
		$this->setField('mark_1', '6');
		$this->setField('mark_2', '1');
		$this->setField('mark_3', '8');
		$this->click('Add Marks');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/dEntry.php?S_ID=3&seminar=1');
		$this->setField('marks_marker', '2');
		$this->setField('mark_1', '2');
		$this->setField('mark_2', '4');
		$this->setField('mark_3', '7');
		$this->click('Add Marks');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/dEntry.php?S_ID=3&seminar=1');
		$this->setField('marks_marker', '3');
		$this->setField('mark_1', '6');
		$this->setField('mark_2', '7');
		$this->setField('mark_3', '9');
		$this->click('Add Marks');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/dEntry.php?S_ID=3&seminar=2');
		$this->setField('marks_marker', '1');
		$this->setField('mark_1', '5');
		$this->setField('mark_2', '3');
		$this->setField('mark_3', '7');
		$this->click('Add Marks');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/dEntry.php?S_ID=3&seminar=2');
		$this->setField('marks_marker', '2');
		$this->setField('mark_1', '6');
		$this->setField('mark_2', '5');
		$this->setField('mark_3', '6');
		$this->click('Add Marks');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/dEntry.php?S_ID=3&seminar=2');
		$this->setField('marks_marker', '3');
		$this->setField('mark_1', '2');
		$this->setField('mark_2', '2');
		$this->setField('mark_3', '4');
		$this->click('Add Marks');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		
		$this->assertText('211280995.002.334.0039.30%4.335.664.6647.30%');
		$this->assertText('211299114.664.008.0072.60%4.333.335.6653.00%');
		$this->assertText('1234567895.003.336.0056.30%4.663.334.0040.00%');
		$this->assertText('Proposal356.06%72.60%39.30%33.30%13.59');
		$this->assertText('Final346.76%53.00%40.00%13.00%5.32');
		
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Marker.php');
		$this->assertNoText('Thomas Edison4.333.003.0031.30%38.00%64.00%23.70');
		}
		}
    }
}

?>
