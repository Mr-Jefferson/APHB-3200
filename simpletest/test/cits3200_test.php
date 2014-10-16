<?php
require_once(dirname(__FILE__) . '/../autorun.php');
require_once(dirname(__FILE__) . '/../web_tester.php');

class TestOfCits3200 extends WebTestCase {
    
    function testHomepage() {
		echo "----------- LOGIN TEST -----------<br><br>";
		{
		echo "Testing login. - Incorrectly<br>";
        $this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		$this->setField('username', 'adminn');
		$this->setField('password', 'passwoord');
		$this->click('Login');
		$this->assertNoText('Proposal');
				
		echo "Testing login. - Correctly<br>";
        $this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		$this->setField('username', 'admin');
		$this->setField('password', 'password');
		$this->click('Login');
		$this->assertText('Proposal');
		}
		/*echo "----------- STUDENT ADD TEST -----------<br><br>";
		{
		echo "Test adding student. - Correctly <br>";
		$this->click('Add Student');
		$this->setField('S_SD', '987654321');
		$this->setField('S_FN', 'testa');
		$this->setField('S_LN', 'tseta');
		$this->click('create');
		$this->assertText('987654321');
		
		echo "Test adding student. - SpecialCharacters - FirstName <br>";
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		$this->click('Add Student');
		$this->setField('S_SD', '987654322');
		$this->setField('S_FN', '?testb');
		$this->setField('S_LN', 'tsetb');
		$this->click('create');
		$this->assertNoText('987654322');
		
		echo "Test adding student. - SpecialCharacters - LastName <br>";
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		$this->click('Add Student');
		$this->setField('S_SD', '987654323');
		$this->setField('S_FN', 'testc');
		$this->setField('S_LN', '?tsetc');
		$this->click('create');
		$this->assertNoText('98765433');
		
		echo "Test adding student. - SpecialCharacters - StudentNumber <br>";
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		$this->click('Add Student');
		$this->setField('S_SD', '?987654324');
		$this->setField('S_FN', 'testd');
		$this->setField('S_LN', 'tsetd');
		$this->click('create');
		$this->assertNoText('testd');
		
		echo "Test adding student. - NotANumber - StudentNumber <br>";
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		$this->click('Add Student');
		$this->setField('S_SD', 'teststnum');
		$this->setField('S_FN', 'teste');
		$this->setField('S_LN', 'tsete');
		$this->click('create');
		$this->assertNoText('teste');
		
		echo "Test adding student. - Null - FirstName <br>";
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		$this->click('Add Student');
		$this->setField('S_SD', '987654326');
		$this->setField('S_FN', '');
		$this->setField('S_LN', 'tsetf');
		$this->click('create');
		$this->assertNoText('987654326');
		
		echo "Test adding student. - Null - LastName <br>";
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		$this->click('Add Student');
		$this->setField('S_SD', '987654327');
		$this->setField('S_FN', 'testg');
		$this->setField('S_LN', '');
		$this->click('create');
		$this->assertNoText('987654327');
		
		echo "Test adding student. - Null - StudentNumber <br>";
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		$this->click('Add Student');
		$this->setField('S_SD', '');
		$this->setField('S_FN', 'testh');
		$this->setField('S_LN', 'tseth');
		$this->click('create');
		$this->assertNoText('testh');
		}
		echo "----------- MARKER ADD TEST -----------<br><br>";
		{
		echo "Test adding marker. - Correctly <br>";
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Marker.php');
		$this->click('Add Marker');
		$this->setField('M_FN', 'testi');
		$this->setField('M_LN', 'tseti');
		$this->click('create');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Marker.php?M_ID=8');
		$this->assertText('testi tseti');
		
		echo "Test adding marker. - SpecialCharacters - FirstName<br>";
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Marker.php');
		$this->click('Add Marker');
		$this->setField('M_FN', '?testj');
		$this->setField('M_LN', 'tsetj');
		$this->click('create');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Marker.php?M_ID=9');
		$this->assertNoText('tsetj');
		
		echo "Test adding marker. - SpecialCharacters - LastName<br>";
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Marker.php');
		$this->click('Add Marker');
		$this->setField('M_FN', 'testk');
		$this->setField('M_LN', '?tsetk');
		$this->click('create');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Marker.php?M_ID=9');
		$this->assertNoText('testk');
		
		echo "Test adding marker. - Null - FirstName<br>";
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Marker.php');
		$this->click('Add Marker');
		$this->setField('M_FN', '');
		$this->setField('M_LN', 'tsetl');
		$this->click('create');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Marker.php?M_ID=9');
		$this->assertNoText('tsetl');
		
		echo "Test adding marker. - Null - LastName<br>";
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Marker.php');
		$this->click('Add Marker');
		$this->setField('M_FN', 'testm');
		$this->setField('M_LN', '');
		$this->click('create');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Marker.php?M_ID=9');
		$this->assertNoText('testm');
		
		}
		
		echo "----------- MARKS ADD TEST -----------<br><br>";
		//{
		echo "Test adding marks - Correctly<br>";
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/dEntry.php?S_ID=8&seminar=1');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php?S_ID=8');
		$this->click('Add');
		$this->assertText('Oral Delivery');
		$this->assertText('Proposal');
		$this->setField('mark_1', 1);
		$this->setField('mark_2', 2);
		$this->setField('mark_3', 3);
		$this->assertField('mark_1', 1);
		$this->assertField('mark_2', 2);
		$this->assertField('mark_3', 3);
		$this->click('Add Marks');
		//$this->post(
        //       '../Helpers/Updater.php?insert=1&S_ID=8',
        //       array('mark_1' => '1','mark_2' => '2','mark_3' => '3'));
		//$this->clickSubmit('Add Marks', array('mark_1' => '1','mark_2' => '2','mark_3' => '3'));
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		$this->assertText('2.70');
		
		echo "Test adding marks - NotANumber - Mark1<br>";
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/dEntry.php?S_ID=8&seminar=1');
		$this->setField('mark_1', '?1');
		$this->setField('mark_2', '2');
		$this->setField('mark_3', '3');
		$this->click('Add Marks');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		$this->assertText('6.00');
		
		echo "Test adding marks - NotANumber - Mark2<br>";
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/dEntry.php?S_ID=42&seminar=1');
		$this->setField('mark_1', '1');
		$this->setField('mark_2', '?2');
		$this->setField('mark_3', '3');
		$this->click('Add Marks');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		$this->assertText('6.00');
		
		echo "Test adding marks - NotANumber - Mark3<br>";
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/dEntry.php?S_ID=42&seminar=1');
		$this->setField('mark_1', '1');
		$this->setField('mark_2', '2');
		$this->setField('mark_3', '?3');
		$this->click('Add Marks');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		$this->assertText('6.00');
		
		echo "Test adding marks - Null - Mark1<br>";
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/dEntry.php?S_ID=42&seminar=1');
		$this->setField('mark_1', '');
		$this->setField('mark_2', '2');
		$this->setField('mark_3', '3');
		$this->click('Add Marks');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		$this->assertText('6.00');
		
		echo "Test adding marks - Null - Mark2<br>";
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/dEntry.php?S_ID=42&seminar=1');
		$this->setField('mark_1', '1');
		$this->setField('mark_2', '');
		$this->setField('mark_3', '3');
		$this->click('Add Marks');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		$this->assertText('6.00');
		
		echo "Test adding marks - Null - Mark3<br>";
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/dEntry.php?S_ID=42&seminar=1');
		$this->setField('mark_1', '1');
		$this->setField('mark_2', '2');
		$this->setField('mark_3', '');
		$this->click('Add Marks');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		$this->assertText('6.00');
		}
		*/
		echo "----------- STUDENT UPDATE TEST -----------<br><br>";
		//{
		echo "Test updating student - Correctly<br>";
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php?S_ID=2');
		$this->click('Update Student');
		$this->assertNoText('Student Number');
		$this->setFieldById('ssd2', '123456789');
		$this->setFieldById('sfn2', 'Nikola');
		$this->setFieldById('sln2', 'Tesla');
		$this->assertFieldById('ssd2', '123456789');
		$this->assertFieldById('sfn2', 'Nikola');
		$this->assertFieldById('sln2', 'Tesla');
		$this->click('Update');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		$this->assertText('Nikola');
		/*
		echo "Test updating student - SpecialCharacters - StudentNumber<br>";
		$this->get('http://localhost/CITS3200_Group_H/Library/Pages/Student.php?S_ID=8');
		$this->click('Update Student');
		$this->setField('S_SD', '?123456789');
		$this->setField('S_FN', 'Nikola');
		$this->setField('S_LN', 'Tesla');
		$this->click('Update');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		$this->assertNoText('?123456789');
		
		echo "Test updating student - SpecialCharacters - FirstName<br>";
		$this->get('http://localhost/CITS3200_Group_H/Library/Pages/Student.php?S_ID=8');
		$this->click('Update Student');
		$this->setField('S_SD', '123456789');
		$this->setField('S_FN', '?Nikola');
		$this->setField('S_LN', 'Tesla');
		$this->click('Update');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		$this->assertNoText('?Nikola');
		
		echo "Test updating student - SpecialCharacters - LastName<br>";
		$this->get('http://localhost/CITS3200_Group_H/Library/Pages/Student.php?S_ID=8');
		$this->click('Update Student');
		$this->setField('S_SD', '123456789');
		$this->setField('S_FN', 'Nikola');
		$this->setField('S_LN', '?Tesla');
		$this->click('Update');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		$this->assertNoText('?Tesla');
		
		echo "Test updating student - Null - StudentNumber<br>";
		$this->get('http://localhost/CITS3200_Group_H/Library/Pages/Student.php?S_ID=8');
		$this->click('Update Student');
		$this->setField('S_SD', '');
		$this->setField('S_FN', 'Nikola');
		$this->setField('S_LN', 'Tesla');
		$this->click('Update');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		$this->assertText('123456789');
		
		echo "Test updating student - Null - FirstName<br>";
		$this->get('http://localhost/CITS3200_Group_H/Library/Pages/Student.php?S_ID=8');
		$this->click('Update Student');
		$this->setField('S_SD', '123456789');
		$this->setField('S_FN', '');
		$this->setField('S_LN', 'Tesla');
		$this->click('Update');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		$this->assertText('Nikola');
		
		echo "Test updating student - Null - LastName<br>";
		$this->get('http://localhost/CITS3200_Group_H/Library/Pages/Student.php?S_ID=8');
		$this->click('Update Student');
		$this->setField('S_SD', '123456789');
		$this->setField('S_FN', 'Nikola');
		$this->setField('S_LN', '');
		$this->click('Update');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		$this->assertText('Tesla');
		
		echo "Test deleting student<br>";
		$this->get('http://localhost/CITS3200_Group_H/Library/Pages/Student.php?S_ID=8');
		$this->click('Update Student');
		$this->click('Delete');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		$this->assertNoText('Nikola');
		}
		echo "----------- MARKER UPDATE TEST -----------<br><br>";
		{
		echo "Test updating marker - Correctly<br>";
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Marker.php?M_ID=7');
		$this->click('Update Marker');
		$this->setField('M_FN', 'Thomas');
		$this->setField('M_LN', 'Edison');
		$this->click('Update');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Marker.php');
		$this->assertText('Edison');
		
		echo "Test updating marker - SpecialCharacters - FirstName<br>";
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Marker.php?M_ID=7');
		$this->click('Update Marker');
		$this->setField('M_FN', '?Thomas');
		$this->setField('M_LN', 'Edison');
		$this->click('Update');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Marker.php');
		$this->assertNoText('?Thomas');
		
		echo "Test updating marker - SpecialCharacters - LastName<br>";
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Marker.php?M_ID=7');
		$this->click('Update Marker');
		$this->setField('M_FN', 'Thomas');
		$this->setField('M_LN', '?Edison');
		$this->click('Update');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Marker.php');
		$this->assertNoText('?Edison');
		
		echo "Test updating marker - Null - FirstName<br>";
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Marker.php?M_ID=7');
		$this->click('Update Marker');
		$this->setField('M_FN', '');
		$this->setField('M_LN', 'Edison');
		$this->click('Update');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Marker.php');
		$this->assertText('Thomas');
		
		echo "Test updating marker - Null - LastName<br>";
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Marker.php?M_ID=7');
		$this->click('Update Marker');
		$this->setField('M_FN', 'Thomas');
		$this->setField('M_LN', '');
		$this->click('Update');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Marker.php');
		$this->assertText('Edison');
		
		echo "Test deleting marker<br>";
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Marker.php?M_ID=7');
		$this->click('Update Marker');
		$this->click('Delete');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Marker.php');
		$this->assertNoText('Edison');
		}
		echo "----------- MARKS UPDATE TEST -----------<br><br>";
		/*{
		echo "Test updating marks - Correctly<br>";
		$this->get('http://localhost/CITS3200_Group_H/Library/Pages/dEntry.php?Mark_ID=7');
		$this->setField('mark_1', '9');
		$this->setField('mark_2', '8');
		$this->setField('mark_3', '7');
		$this->click('Update');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php?S_ID=2');
		$this->assertText('24.00');
		
		echo "Test updating marks - SpecialCharacters - Mark1<br>";
		$this->get('http://localhost/CITS3200_Group_H/Library/Pages/dEntry.php?Mark_ID=7');
		$this->setField('mark_1', '?6');
		$this->setField('mark_2', '5');
		$this->setField('mark_3', '4');
		$this->click('Update');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php?S_ID=2');
		$this->assertText('24.00');
		
		echo "Test updating marks - SpecialCharacters - Mark2<br>";
		$this->get('http://localhost/CITS3200_Group_H/Library/Pages/dEntry.php?Mark_ID=7');
		$this->setField('mark_1', '6');
		$this->setField('mark_2', '?5');
		$this->setField('mark_3', '4');
		$this->click('Update');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php?S_ID=2');
		$this->assertText('24.00');
		
		echo "Test updating marks - SpecialCharacters - Mark3<br>";
		$this->get('http://localhost/CITS3200_Group_H/Library/Pages/dEntry.php?Mark_ID=7');
		$this->setField('mark_1', '6');
		$this->setField('mark_2', '5');
		$this->setField('mark_3', '?4');
		$this->click('Update');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php?S_ID=2');
		$this->assertText('24.00');
		
		echo "Test updating marks - Null - Mark1<br>";
		$this->get('http://localhost/CITS3200_Group_H/Library/Pages/dEntry.php?Mark_ID=7');
		$this->setField('mark_1', '');
		$this->setField('mark_2', '5');
		$this->setField('mark_3', '4');
		$this->click('Update');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php?S_ID=2');
		$this->assertText('24.00');
		
		echo "Test updating marks - Null - Mark2<br>";
		$this->get('http://localhost/CITS3200_Group_H/Library/Pages/dEntry.php?Mark_ID=7');
		$this->setField('mark_1', '6');
		$this->setField('mark_2', '');
		$this->setField('mark_3', '4');
		$this->click('Update');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php?S_ID=2');
		$this->assertText('24.00');
		
		echo "Test updating marks - Null - Mark3<br>";
		$this->get('http://localhost/CITS3200_Group_H/Library/Pages/dEntry.php?Mark_ID=7');
		$this->setField('mark_1', '6');
		$this->setField('mark_2', '5');
		$this->setField('mark_3', '');
		$this->click('Update');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php?S_ID=2');
		$this->assertText('24.00');
		
		echo "Test deleting marks<br>";
		$this->get('http://localhost/CITS3200_Group_H/Library/Pages/dEntry.php?Mark_ID=7');
		$this->click('Delete');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php?S_ID=2');
		$this->assertNoText('24.00');
		}
		echo "----------- CALCULATIONS TEST -----------<br><br>";
		{
		echo "Adding Calculation test student.<br>";
		$this->click('Add Student');
		$this->setField('S_SD', '7357');
		$this->setField('S_FN', 'Calculation');
		$this->setField('S_LN', 'Student');
		$this->click('create');
		$this->assertText('Calculation');
		
		echo "Adding Calculation test marker<br>";
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Marker.php');
		$this->click('Add Marker');
		$this->setField('M_FN', 'Calculator');
		$this->setField('M_LN', 'Marker');
		$this->click('create');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/dEntry.php?S_ID=8&seminar=1');
		$this->assertTrue($this->setFieldByID('marks_marker', 'Calculator Marker'));
		
		echo "Adding Calculation test marks<br>";
		$this->setField('mark_1', '1');
		$this->setField('mark_2', '2');
		$this->setField('mark_3', '3');
		$this->click('Add Marks');
		
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/dEntry.php?S_ID=8&seminar=1');
		$this->assertTrue($this->setFieldByID('marks_marker', 'Calculator Marker'));
		$this->setField('mark_1', '4');
		$this->setField('mark_2', '5');
		$this->setField('mark_3', '6');
		$this->click('Add Marks');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		$this->assertText('73571.002.003.006.004.005.006.0015.00');
		}
		*/
		//$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		//$this->assertNoText('73571.002.003.002.704.005.006.005.70');
		//$result = $this->Database_connection->query_Database("select * from students");
		
    }
}

?>