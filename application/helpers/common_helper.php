<?php 



//cast or jati

function castArray(){

	

	return array(
			array("id"=>0,"name"=>"","name_guj"=>"--પસંદ કરો--"),
			array("id"=>1,"name"=>"","name_guj"=>"અનુ.જાતિ"),

			array("id"=>2,"name"=>"","name_guj"=>"અનુ.જનજાતિ"),

			array("id"=>3,"name"=>"","name_guj"=>"સામાજીક અને શૈક્ષણિક રીતે પછાત"),

			array("id"=>4,"name"=>"","name_guj"=>"અન્ય"),

			);

}

function getCastById($id){

	$casts = castArray();

	foreach($casts as $cast){

		if($cast["id"] == $id)

			return $cast; 

	}

	return false;

}



//Khodkhapan or handicap 

function handicapArray(){



	return array(
			array("id"=>0,"name"=>"","name_guj"=>"--પસંદ કરો--"),
			array("id"=>1,"name"=>"","name_guj"=>"હલનચલન"),

			array("id"=>2,"name"=>"","name_guj"=>"માનસિક"),

			array("id"=>3,"name"=>"","name_guj"=>"અંધાપો"),

			array("id"=>4,"name"=>"","name_guj"=>"બહેરાશ"),

			array("id"=>5,"name"=>"","name_guj"=>"મૂંગાપણું"),

	);

}

function getHandicapById($id){

	$handicaps = handicapArray();

	foreach($handicaps as $handicap){

		if($handicap["id"] == $id)

			return $handicap;

	}

	return false;

}



//Dharm or religion

function religionArray(){



	return array(
			array("id"=>0,"name"=>"","name_guj"=>"--પસંદ કરો--"),
			array("id"=>1,"name"=>"","name_guj"=>"બુદ્ધ"),

			array("id"=>2,"name"=>"","name_guj"=>"ખ્રિસ્તી"),

			array("id"=>3,"name"=>"","name_guj"=>"હિંદુ"),

			array("id"=>4,"name"=>"","name_guj"=>"ઇસ્લામ"),

			array("id"=>5,"name"=>"","name_guj"=>"જૈન"),

			array("id"=>6,"name"=>"","name_guj"=>"શીખ"),

			array("id"=>7,"name"=>"","name_guj"=>"અન્ય"),

	);

}

function getReligionById($id){

	$religions = religionArray();

	foreach($religions as $religion){

		if($religion["id"] == $id)

			return $religion;

	}

	return false;

}



//સ્થળ or place

function placeArray(){



	return array(
			array("id"=>0,"name"=>"","name_guj"=>"--પસંદ કરો--"),
			array("id"=>1,"name"=>"","name_guj"=>"શેરી"),

			array("id"=>2,"name"=>"","name_guj"=>"વાસ"),

			array("id"=>3,"name"=>"","name_guj"=>"ફળીયું"),

			array("id"=>4,"name"=>"","name_guj"=>"વોર્ડ"),

	);

}

function getPlaceById($id){

	$places = placeArray();

	foreach($places as $place){

		if($place["id"] == $id)

			return $place;

	}

	return false;

}



//relationWithFamilyHead

function relationArray(){



	return array(
			array("id"=>0,"name"=>"","name_guj"=>"--પસંદ કરો--"),
			array("id"=>1,"name"=>"","name_guj"=>"પોતે"),

			array("id"=>2,"name"=>"","name_guj"=>"પત્નિ"),

			array("id"=>3,"name"=>"","name_guj"=>"પતિ"),

			array("id"=>4,"name"=>"","name_guj"=>"પુત્ર"),

			array("id"=>5,"name"=>"","name_guj"=>"પુત્રી"),

			array("id"=>6,"name"=>"","name_guj"=>"પુત્રવધૂ"),

			array("id"=>7,"name"=>"","name_guj"=>"પૌત્ર"),

			array("id"=>8,"name"=>"","name_guj"=>"પૌત્રવધુ"),

			array("id"=>9,"name"=>"","name_guj"=>"પ્રપૌત્ર"),

			array("id"=>10,"name"=>"","name_guj"=>"પ્રપૌત્રવધુ"),

			array("id"=>11,"name"=>"","name_guj"=>"પ્રપૌત્રી"),

			array("id"=>12,"name"=>"","name_guj"=>"જમાઈ"),

			array("id"=>13,"name"=>"","name_guj"=>"ભાણેજ"),

			array("id"=>14,"name"=>"","name_guj"=>"ભાણજી"),

			array("id"=>15,"name"=>"","name_guj"=>"દોહિત્ર"),

			array("id"=>16,"name"=>"","name_guj"=>"દોહિત્રી"),

			array("id"=>17,"name"=>"","name_guj"=>"દતક પુત્ર"),

			array("id"=>18,"name"=>"","name_guj"=>"દતક પુત્રી"),

			array("id"=>19,"name"=>"","name_guj"=>"અનાથ"),

			array("id"=>20,"name"=>"","name_guj"=>"પૌત્રી"),

			array("id"=>21,"name"=>"","name_guj"=>"ભાઈ"),

			array("id"=>22,"name"=>"","name_guj"=>"ભાઈ"),

			array("id"=>23,"name"=>"","name_guj"=>"ભાભી"),

			array("id"=>24,"name"=>"","name_guj"=>"બહેન"),

			array("id"=>25,"name"=>"","name_guj"=>"ભત્રીજી"),

			array("id"=>26,"name"=>"","name_guj"=>"ભત્રીજા"),

	);

}

function getRelationById($id){

	$relations = relationArray();

	foreach($relations as $relation){

		if($relation["id"] == $id)

			return $relation;

	}

	return false;

}



//જાતિ OR Gender

function genderArray(){



	return array(
			array("id"=>0,"name"=>"","name_guj"=>"--પસંદ કરો--"),
			array("id"=>1,"name"=>"","name_guj"=>"પુરૂષ"),

			array("id"=>2,"name"=>"","name_guj"=>"સ્ત્રી"),

			array("id"=>3,"name"=>"","name_guj"=>"ટ્રાન્સજેન્ડર"),

	);

}

function getGenderById($id){

	$genders = genderArray();

	foreach($genders as $gender){

		if($gender["id"] == $id)

			return $gender;

	}

	return false;

}



//વૈવાહિક દરજ્જો OR maritalStatus

function maritalStatusArray(){



	return array(
			array("id"=>0,"name"=>"","name_guj"=>"--પસંદ કરો--"),
			array("id"=>1,"name"=>"","name_guj"=>"પરિણીત"),

			array("id"=>2,"name"=>"","name_guj"=>"અપરિણીત"),

			array("id"=>3,"name"=>"","name_guj"=>"વિધુર"),

			array("id"=>4,"name"=>"","name_guj"=>"વિધવા"),

			array("id"=>5,"name"=>"","name_guj"=>"ત્યકતા"),

	);

}

function getMaritalStatusById($id){

	$maritalStatuss = maritalStatusArray();

	foreach($maritalStatuss as $maritalStatus){

		if($maritalStatus["id"] == $id)

			return $maritalStatus;

	}

	return false;

}



//લક્ષ્યાંક કોડ OR targetCode

function targetCodeArray(){



	return array(

array("id"=>0,"name"=>"","name_guj"=>"--પસંદ કરો--"),			
array("id"=>"1","name"=>"","name_guj"=>"લાગુ નથી"),

			array("id"=>"P","name"=>"","name_guj"=>"P- સગર્ભા"),

			array("id"=>"L","name"=>"","name_guj"=>"L- ધાત્રી"),

			array("id"=>"C","name"=>"","name_guj"=>"C- બાળક"),

			array("id"=>"A","name"=>"","name_guj"=>"A- કિશોરી"),

	);

}

function getTargetCodeById($id){

	$targetCodes = targetCodeArray();

	foreach($targetCodes as $targetCode){

		if($targetCode["id"] == $id)

			return $targetCode;

	}

	return false;

}



//ખોડખાંપણ કોડ OR malformationType

function malformationTypeArray(){



	return array(

array("id"=>0,"name"=>"","name_guj"=>"--પસંદ કરો--"),			
array("id"=>1,"name"=>"","name_guj"=>"કોઈ ખોડખાંપણ નથી"),

			array("id"=>2,"name"=>"","name_guj"=>"હલનચલન"),

			array("id"=>3,"name"=>"","name_guj"=>"માનસિક"),

			array("id"=>4,"name"=>"","name_guj"=>"અંધાપો"),

			array("id"=>5,"name"=>"","name_guj"=>"બહેરાશ"),

			array("id"=>6,"name"=>"","name_guj"=>"મૂંગાપણું"),

	);

}

function getMalformationTypeById($id){

	$malformationTypes = malformationTypeArray();

	foreach($malformationTypes as $malformationType){

		if($malformationType["id"] == $id)

			return $malformationType;

	}

	return false;

}



//આંગણવાડીની નીચેની સેવાઓ પ્રાપ્ત કરવાની ઈચ્છા ધરાવે છે? (anganwadiServices)

function anganwadiServicesArray(){



	return array(

			array("id"=>1,"name"=>"","name_guj"=>"પૂરક આહાર"),

			array("id"=>2,"name"=>"","name_guj"=>"પૂર્વ પ્રાથમિક શિક્ષણ"),

	);

}

function getAnganwadiServicesById($id){

	$anganwadiServicess = anganwadiServicesArray();

	foreach($anganwadiServicess as $anganwadiServices){

		if($anganwadiServices["id"] == $id)

			return $anganwadiServices;

	}

	return false;

}



