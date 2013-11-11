<select name="timezone">
<option>Time Zone...</option>

<?
$tzlist = array();
static $regions = array(
    'Africa' => DateTimeZone::AFRICA,
    'America' => DateTimeZone::AMERICA,
    'Antarctica' => DateTimeZone::ANTARCTICA,
    'Asia' => DateTimeZone::ASIA,
    'Atlantic' => DateTimeZone::ATLANTIC,
    'Australia' => DateTimeZone::AUSTRALIA,
    'Europe' => DateTimeZone::EUROPE,
    'Indian' => DateTimeZone::INDIAN,
    'Pacific' => DateTimeZone::PACIFIC
);

foreach ($regions as $region_name => $mask) {
	$region = array('name' => $region_name, 'zones' => DateTimeZone::listIdentifiers($mask));
	$tzlist[] = $region;
}

?>

<? foreach ($tzlist as $region) : ?>
<optgroup label="<?=$region['name']?>">
<? foreach ($region['zones'] as $zone) : ?>
<option value="<?=$zone?>" <? if ($account->timezone == $zone) echo 'selected' ?>><?=$zone?></option>
<? endforeach ?>
</optgroup>
<? endforeach ?>

</select>