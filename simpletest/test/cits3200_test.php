<?php
require_once(dirname(__FILE__) . '/../autorun.php');
require_once(dirname(__FILE__) . '/../web_tester.php');

class TestOfCits3200 extends WebTestCase {
    
    function testHomepage() {
		echo "----------- LOGIN TEST -----------<br><br>";
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
		
		echo "----------- STUDENT ADD TEST -----------<br><br>";
		{
		echo "Test adding student. - Correctly <br>";
		$this->click('Add Student');
		$this->setField('S_SD', '987654321');
		$this->setField('S_FN', 'testa');
		$this->setField('S_LN', 'tseta');
		$this->clickSubmitById('Screate');
		$this->assertText('987654321');
		
		echo "Test adding student. - SpecialCharacters - FirstName <br>";
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		$this->click('Add Student');
		$this->setField('S_SD', '987654322');
		$this->setField('S_FN', '?testb');
		$this->setField('S_LN', 'tsetb');
		$this->clickSubmitById('Screate');
		$this->assertNoText('987654322');
		
		echo "Test adding student. - SpecialCharacters - LastName <br>";
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		$this->click('Add Student');
		$this->setField('S_SD', '987654323');
		$this->setField('S_FN', 'testc');
		$this->setField('S_LN', '?tsetc');
		$this->clickSubmitById('Screate');
		$this->assertNoText('987654323');
		
		echo "Test adding student. - SpecialCharacters - StudentNumber <br>";
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		$this->click('Add Student');
		$this->setField('S_SD', '?987654324');
		$this->setField('S_FN', 'testd');
		$this->setField('S_LN', 'tsetd');
		$this->clickSubmitById('Screate');
		$this->assertNoText('testd');
		
		echo "Test adding student. - NotANumber - StudentNumber <br>";
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		$this->click('Add Student');
		$this->setField('S_SD', 'teststnum');
		$this->setField('S_FN', 'teste');
		$this->setField('S_LN', 'tsete');
		$this->clickSubmitById('Screate');
		$this->assertNoText('teste');
		
		echo "Test adding student. - Null - FirstName <br>";
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		$this->click('Add Student');
		$this->setField('S_SD', '987654326');
		$this->setField('S_FN', '');
		$this->setField('S_LN', 'tsetf');
		$this->clickSubmitById('Screate');
		$this->assertNoText('987654326');
		
		echo "Test adding student. - Null - LastName <br>";
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		$this->click('Add Student');
		$this->setField('S_SD', '987654327');
		$this->setField('S_FN', 'testg');
		$this->setField('S_LN', '');
		$this->clickSubmitById('Screate');
		$this->assertNoText('987654327');
		
		echo "Test adding student. - Null - StudentNumber <br>";
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		$this->click('Add Student');
		$this->setField('S_SD', '');
		$this->setField('S_FN', 'testh');
		$this->setField('S_LN', 'tseth');
		$this->clickSubmitById('Screate');
		$this->assertNoText('testh');
		}

		echo "----------- MARKER ADD TEST -----------<br><br>";
		{
		echo "Test adding marker. - Correctly <br>";
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Marker.php');
		$this->click('Add Marker');
		$this->setField('M_FN', 'testi');
		$this->setField('M_LN', 'tseti');
		$this->clickSubmitById('Mcreate');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Marker.php?M_ID=1');
		$this->assertText('testi');
		
		echo "Test adding marker. - SpecialCharacters - FirstName<br>";
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Marker.php');
		$this->click('Add Marker');
		$this->setField('M_FN', '?testj');
		$this->setField('M_LN', 'tsetj');
		$this->clickSubmitById('Mcreate');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Marker.php?M_ID=2');
		$this->assertNoText('tsetj');
		
		echo "Test adding marker. - SpecialCharacters - LastName<br>";
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Marker.php');
		$this->click('Add Marker');
		$this->setField('M_FN', 'testk');
		$this->setField('M_LN', '?tsetk');
		$this->clickSubmitById('Mcreate');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Marker.php?M_ID=2');
		$this->assertNoText('testk');
		
		echo "Test adding marker. - Null - FirstName<br>";
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Marker.php');
		$this->click('Add Marker');
		$this->setField('M_FN', '');
		$this->setField('M_LN', 'tsetl');
		$this->clickSubmitById('Mcreate');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Marker.php?M_ID=2');
		$this->assertNoText('tsetl');
		
		echo "Test adding marker. - Null - LastName<br>";
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Marker.php');
		$this->click('Add Marker');
		$this->setField('M_FN', 'testm');
		$this->setField('M_LN', '');
		$this->clickSubmitById('Mcreate');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Marker.php?M_ID=2');
		$this->assertNoText('testm');
		}
		
		echo "----------- MARKS ADD TEST -----------<br><br>";
		{
		echo "Test adding marks - Correctly<br>";
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/dEntry.php?S_ID=1&seminar=1');
		$this->assertText('Oral Delivery');
		$this->setField('mark_1', '1');
		$this->setField('mark_2', '2');
		$this->setField('mark_3', '4');
		$this->clickSubmit('Add Marks');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		$this->assertText('35.0');
		
		echo "Test adding marks - NotANumber - Mark1<br>";
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/dEntry.php?S_ID=1&seminar=2');
		$this->setField('mark_1', '?1');
		$this->setField('mark_2', '2');
		$this->setField('mark_3', '3');
		$this->clickSubmit('Add Marks');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		$this->assertNoText('27.0');
		
		echo "Test adding marks - NotANumber - Mark2<br>";
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/dEntry.php?S_ID=1&seminar=2');
		$this->setField('mark_1', '1');
		$this->setField('mark_2', '?2');
		$this->setField('mark_3', '3');
		$this->clickSubmit('Add Marks');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		$this->assertNoText('27.0');
		
		echo "Test adding marks - NotANumber - Mark3<br>";
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/dEntry.php?S_ID=1&seminar=2');
		$this->setField('mark_1', '1');
		$this->setField('mark_2', '2');
		$this->setField('mark_3', '?3');
		$this->clickSubmit('Add Marks');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		$this->assertNoText('27.0');
		
		echo "Test adding marks - Null - Mark1<br>";
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/dEntry.php?S_ID=1&seminar=2');
		$this->setField('mark_1', '');
		$this->setField('mark_2', '2');
		$this->setField('mark_3', '3');
		$this->clickSubmit('Add Marks');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		$this->assertNoText('27.0');
		
		echo "Test adding marks - Null - Mark2<br>";
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/dEntry.php?S_ID=1&seminar=2');
		$this->setField('mark_1', '1');
		$this->setField('mark_2', '');
		$this->setField('mark_3', '3');
		$this->clickSubmit('Add Marks');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		$this->assertNoText('27.0');
		
		echo "Test adding marks - Null - Mark3<br>";
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/dEntry.php?S_ID=1&seminar=2');
		$this->setField('mark_1', '1');
		$this->setField('mark_2', '2');
		$this->setField('mark_3', '');
		$this->clickSubmit('Add Marks');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		$this->assertNoText('27.0');
		}
		
		echo "----------- STUDENT UPDATE TEST -----------<br><br>";
		{
		echo "Test updating student - Correctly<br>";
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php?S_ID=1');
		$this->click('Update Student ');
		$this->setFieldById('ssd2', '123456789');
		$this->setFieldById('sfn2', 'Nikola');
		$this->setFieldById('sln2', 'Tesla');
		$this->assertField('year', '2014');
		$this->assertField('sem', '2');
		$this->showSource();
		$this->clickSubmitById('SUpdate');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		$this->assertText('Nikola');
		
		echo "Test updating student - SpecialCharacters - StudentNumber<br>";
		$this->get('http://localhost/CITS3200_Group_H/Library/Pages/Student.php?S_ID=1');
		$this->click('Update Student ');
		$this->setFieldById('ssd2', '?123456789');
		$this->setFieldById('sfn2', 'Nikola');
		$this->setFieldById('sln2', 'Tesla');
		$this->clickSubmitById('SUpdate');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		$this->assertNoText('?123456789');
		
		echo "Test updating student - SpecialCharacters - FirstName<br>";
		$this->get('http://localhost/CITS3200_Group_H/Library/Pages/Student.php?S_ID=1');
		$this->click('Update Student ');
		$this->setFieldById('ssd2', '123456789');
		$this->setFieldById('sfn2', '?Nikola');
		$this->setFieldById('sln2', 'Tesla');
		$this->clickSubmitById('SUpdate');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		$this->assertNoText('?Nikola');
		
		echo "Test updating student - SpecialCharacters - LastName<br>";
		$this->get('http://localhost/CITS3200_Group_H/Library/Pages/Student.php?S_ID=1');
		$this->click('Update Student ');
		$this->setFieldById('ssd2', '123456789');
		$this->setFieldById('sfn2', 'Nikola');
		$this->setFieldById('sln2', '?Tesla');
		$this->clickSubmitById('SUpdate');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		$this->assertNoText('?Tesla');
		
		echo "Test updating student - Null - StudentNumber<br>";
		$this->get('http://localhost/CITS3200_Group_H/Library/Pages/Student.php?S_ID=1');
		$this->click('Update Student ');
		$this->setFieldById('ssd2', '');
		$this->setFieldById('sfn2', 'Nikola');
		$this->setFieldById('sln2', 'Tesla');
		$this->clickSubmitById('SUpdate');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		$this->assertText('123456789');
		
		echo "Test updating student - Null - FirstName<br>";
		$this->get('http://localhost/CITS3200_Group_H/Library/Pages/Student.php?S_ID=1');
		$this->click('Update Student ');
		$this->setFieldById('ssd2', '123456789');
		$this->setFieldById('sfn2', '');
		$this->setFieldById('sln2', 'Tesla');
		$this->clickSubmitById('SUpdate');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		$this->assertText('Nikola');
		
		echo "Test updating student - Null - LastName<br>";
		$this->get('http://localhost/CITS3200_Group_H/Library/Pages/Student.php?S_ID=1');
		$this->click('Update Student ');
		$this->setFieldById('ssd2', '123456789');
		$this->setFieldById('sfn2', 'Nikola');
		$this->setFieldById('sln2', '');
		$this->clickSubmitById('SUpdate');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		$this->assertText('Tesla');
		
		}
		echo "----------- MARKER UPDATE TEST -----------<br><br>";
		{
		echo "Test updating marker - Correctly<br>";
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Marker.php?M_ID=1');
		$this->click(' Update Marker');
		$this->setFieldById('mfn2', 'Thomas');
		$this->setFieldById('mln2', 'Edison');
		$this->clickSubmitById('MUpdate');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Marker.php');
		$this->assertText('Edison');
		
		
		echo "Test updating marker - SpecialCharacters - FirstName<br>";
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Marker.php?M_ID=1');
		$this->click(' Update Marker');
		$this->setFieldById('mfn2', '?Thomas');
		$this->setFieldById('mln2', 'Edison');
		$this->clickSubmitById('MUpdate');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Marker.php');
		$this->assertNoText('?Thomas');
		
		
		echo "Test updating marker - SpecialCharacters - LastName<br>";
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Marker.php?M_ID=1');
		$this->click(' Update Marker');
		$this->setFieldById('mfn2', 'Thomas');
		$this->setFieldById('mln2', '?Edison');
		$this->clickSubmitById('MUpdate');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Marker.php');
		$this->assertNoText('?Edison');
		
		echo "Test updating marker - Null - FirstName<br>";
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Marker.php?M_ID=1');
		$this->click(' Update Marker');
		$this->setFieldById('mfn2', '');
		$this->setFieldById('mln2', 'Edison');
		$this->clickSubmitById('MUpdate');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Marker.php');
		$this->assertText('Thomas');
		
		echo "Test updating marker - Null - LastName<br>";
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Marker.php?M_ID=1');
		$this->click(' Update Marker');
		$this->setFieldById('mfn2', 'Thomas');
		$this->setFieldById('mln2', '');
		$this->clickSubmitById('MUpdate');
		echo $this->get('http://128.199.218.6/APHB-3200/Library/Pages/Marker.php');
		$this->assertText('Edison');
		}
		
		echo "----------- MARKS UPDATE TEST -----------<br><br>";
		{
		echo "Test updating marks - Correctly<br>";
		echo $this->get('http://localhost/CITS3200_Group_H/Library/Pages/dEntry.php?Mark_ID=1');
		$this->setField('mark_1', '9');
		$this->setField('mark_2', '8');
		$this->setField('mark_3', '7');
		$this->assertField('mark_1', '9');
		$this->assertField('mark_2', '8');
		$this->assertField('mark_3', '7');
		$this->assertField('marks_marker', '1');
		$this->assertField('marks_student', '1');
		$this->assertField('marks_sem_type', '1');
		$this->showSource();
		$this->clickSubmitById('MkUpdate');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php?S_ID=1');
		$this->assertText('73.00');
		
		echo "Test updating marks - SpecialCharacters - Mark1<br>";
		$this->get('http://localhost/CITS3200_Group_H/Library/Pages/dEntry.php?Mark_ID=1');
		$this->setField('mark_1', '?6');
		$this->setField('mark_2', '5');
		$this->setField('mark_3', '4');
		$this->clickSubmitById('MkUpdate');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php?S_ID=1');
		$this->assertText('73.00');
		
		echo "Test updating marks - SpecialCharacters - Mark2<br>";
		$this->get('http://localhost/CITS3200_Group_H/Library/Pages/dEntry.php?Mark_ID=1');
		$this->setField('mark_1', '6');
		$this->setField('mark_2', '?5');
		$this->setField('mark_3', '4');
		$this->clickSubmitById('MkUpdate');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php?S_ID=1');
		$this->assertText('73.00');
		
		echo "Test updating marks - SpecialCharacters - Mark3<br>";
		$this->get('http://localhost/CITS3200_Group_H/Library/Pages/dEntry.php?Mark_ID=1');
		$this->setField('mark_1', '6');
		$this->setField('mark_2', '5');
		$this->setField('mark_3', '?4');
		$this->clickSubmitById('MkUpdate');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php?S_ID=1');
		$this->assertText('73.00');
		
		echo "Test updating marks - Null - Mark1<br>";
		$this->get('http://localhost/CITS3200_Group_H/Library/Pages/dEntry.php?Mark_ID=1');
		$this->setField('mark_1', '');
		$this->setField('mark_2', '5');
		$this->setField('mark_3', '4');
		$this->clickSubmitById('MkUpdate');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php?S_ID=1');
		$this->assertText('73.00');
		
		echo "Test updating marks - Null - Mark2<br>";
		$this->get('http://localhost/CITS3200_Group_H/Library/Pages/dEntry.php?Mark_ID=1');
		$this->setField('mark_1', '6');
		$this->setField('mark_2', '');
		$this->setField('mark_3', '4');
		$this->clickSubmitById('MkUpdate');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php?S_ID=1');
		$this->assertText('73.00');
		
		echo "Test updating marks - Null - Mark3<br>";
		$this->get('http://localhost/CITS3200_Group_H/Library/Pages/dEntry.php?Mark_ID=1');
		$this->setField('mark_1', '6');
		$this->setField('mark_2', '5');
		$this->setField('mark_3', '');
		$this->clickSubmitById('MkUpdate');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php?S_ID=1');
		$this->assertText('73.00');
		}
		/*
		echo "----------- CALCULATIONS TEST -----------<br><br>";
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
		$this->setFieldByID('marks_marker', '2');
		$this->setField('mark_1', '9');
		$this->setField('mark_2', '3');
		$this->setField('mark_3', '6');
		$this->click('Add Marks');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		//$this->assertText('9876543216.506.506.5065.00');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/dEntry.php?S_ID=1&seminar=1');
		$this->setFieldByID('marks_marker', '3');
		$this->setField('mark_1', '5');
		$this->setField('mark_2', '5');
		$this->setField('mark_3', '8');
		$this->click('Add Marks');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		//$this->assertText('9876543216.506.506.5065.00');
		
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/dEntry.php?S_ID=1&seminar=2');
		$this->setFieldByID('marks_marker', '1');
		$this->setField('mark_1', '5');
		$this->setField('mark_2', '1');
		$this->setField('mark_3', '2');
		$this->click('Add Marks');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		//$this->assertText('9876543216.506.506.5065.00');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/dEntry.php?S_ID=1&seminar=2');
		$this->setFieldByID('marks_marker', '2');
		$this->setField('mark_1', '6');
		$this->setField('mark_2', '7');
		$this->setField('mark_3', '4');
		$this->click('Add Marks');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		//$this->assertText('9876543216.506.506.5065.00');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/dEntry.php?S_ID=1&seminar=2');
		$this->setFieldByID('marks_marker', '3');
		$this->setField('mark_1', '3');
		$this->setField('mark_2', '2');
		$this->setField('mark_3', '6');
		$this->click('Add Marks');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		//$this->assertText('9876543216.506.506.5065.00');
		}
		{
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/dEntry.php?S_ID=2&seminar=1');
		$this->setFieldByID('marks_marker', '1');
		$this->setField('mark_1', '7');
		$this->setField('mark_2', '1');
		$this->setField('mark_3', '5');
		$this->click('Add Marks');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		//$this->assertText('9876543216.506.506.5065.00');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/dEntry.php?S_ID=2&seminar=1');
		$this->setFieldByID('marks_marker', '2');
		$this->setField('mark_1', '6');
		$this->setField('mark_2', '4');
		$this->setField('mark_3', '1');
		$this->click('Add Marks');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		//$this->assertText('9876543216.506.506.5065.00');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/dEntry.php?S_ID=2&seminar=1');
		$this->setFieldByID('marks_marker', '3');
		$this->setField('mark_1', '2');
		$this->setField('mark_2', '2');
		$this->setField('mark_3', '6');
		$this->click('Add Marks');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		//$this->assertText('9876543216.506.506.5065.00');
		
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/dEntry.php?S_ID=2&seminar=2');
		$this->setFieldByID('marks_marker', '1');
		$this->setField('mark_1', '3');
		$this->setField('mark_2', '5');
		$this->setField('mark_3', '0');
		$this->click('Add Marks');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		//$this->assertText('9876543216.506.506.5065.00');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/dEntry.php?S_ID=2&seminar=2');
		$this->setFieldByID('marks_marker', '2');
		$this->setField('mark_1', '1');
		$this->setField('mark_2', '3');
		$this->setField('mark_3', '6');
		$this->click('Add Marks');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		//$this->assertText('9876543216.506.506.5065.00');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/dEntry.php?S_ID=2&seminar=2');
		$this->setFieldByID('marks_marker', '3');
		$this->setField('mark_1', '9');
		$this->setField('mark_2', '9');
		$this->setField('mark_3', '8');
		$this->click('Add Marks');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		//$this->assertText('9876543216.506.506.5065.00');
		}
		{
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/dEntry.php?S_ID=3&seminar=1');
		$this->setFieldByID('marks_marker', '1');
		$this->setField('mark_1', '6');
		$this->setField('mark_2', '1');
		$this->setField('mark_3', '8');
		$this->click('Add Marks');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		//$this->assertText('9876543216.506.506.5065.00');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/dEntry.php?S_ID=3&seminar=1');
		$this->setFieldByID('marks_marker', '2');
		$this->setField('mark_1', '2');
		$this->setField('mark_2', '4');
		$this->setField('mark_3', '7');
		$this->click('Add Marks');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		//$this->assertText('9876543216.506.506.5065.00');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/dEntry.php?S_ID=3&seminar=1');
		$this->setFieldByID('marks_marker', '3');
		$this->setField('mark_1', '6');
		$this->setField('mark_2', '7');
		$this->setField('mark_3', '9');
		$this->click('Add Marks');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		//$this->assertText('9876543216.506.506.5065.00');
		
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/dEntry.php?S_ID=3&seminar=2');
		$this->setFieldByID('marks_marker', '1');
		$this->setField('mark_1', '5');
		$this->setField('mark_2', '3');
		$this->setField('mark_3', '7');
		$this->click('Add Marks');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		//$this->assertText('9876543216.506.506.5065.00');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/dEntry.php?S_ID=3&seminar=2');
		$this->setFieldByID('marks_marker', '2');
		$this->setField('mark_1', '6');
		$this->setField('mark_2', '5');
		$this->setField('mark_3', '6');
		$this->click('Add Marks');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		//$this->assertText('9876543216.506.506.5065.00');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/dEntry.php?S_ID=3&seminar=2');
		$this->setFieldByID('marks_marker', '3');
		$this->setField('mark_1', '2');
		$this->setField('mark_2', '2');
		$this->setField('mark_3', '4');
		$this->click('Add Marks');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		//$this->assertText('9876543216.506.506.5065.00');
		}
		}
		
		echo "----------- DELETION TEST -----------<br><br>";
		{
		echo "Test deleting marks<br>";
		$this->get('http://localhost/CITS3200_Group_H/Library/Pages/dEntry.php?Mark_ID=1');
		$this->click('Delete');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php?S_ID=1');
		$this->assertNoText('6.50');
		
		echo "Test deleting student<br>";
		$this->get('http://localhost/CITS3200_Group_H/Library/Pages/Student.php?S_ID=1');
		$this->click('Update Student ');
		$this->click('Delete');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Student.php');
		$this->assertNoText('Nikola');
		
		echo "Test deleting marker<br>";
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Marker.php?M_ID=1');
		$this->click(' Update Marker');
		$this->click('Delete');
		$this->get('http://128.199.218.6/APHB-3200/Library/Pages/Marker.php');
		$this->assertNoText('Edison');
		}
		*/
    }
}

?>
