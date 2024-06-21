<input type="text" name="origin_street" placeholder="Origin street" style="display: none;">
<input type="text" name="origin_state" placeholder="Origin state" style="display: none;">
<input type="text" name="origin_city" placeholder="Origin city" style="display: none;">
<input type="text" name="origin_zip_code" placeholder="Origin zip code" style="display: none;">
<script type="text/javascript"
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCZivnuCLOeof1YXnpv2jFGAbHZAH
he1mI&libraries=places"></script>
<script>
var input = document.querySelector('input[name="origin_street"]');
var options = {
types: ['address']
};
var componentForm = {
street_number: 'short_name',
route: 'long_name',
locality: 'long_name',
administrative_area_level_1: 'short_name',
country: 'long_name',
postal_code: 'short_name'
};
var autocomplete = new google.maps.places.Autocomplete(input, options);
autocomplete.setFields(['address_component']);
function saveAddressInfo(addressInfo) {
sessionStorage.setItem('addressInfo', JSON.stringify(addressInfo));
}
function getAddressInfo() {
var addressInfo = sessionStorage.getItem('addressInfo');
return addressInfo ? JSON.parse(addressInfo) : null;
}
function populateAddressFields(addressInfo) {
if (addressInfo) {
document.querySelector('input[name="origin_street"]').value = addressInfo.address;
document.querySelector('input[name="origin_state"]').value = addressInfo.city;
document.querySelector('input[name="origin_city"]').value = addressInfo.state;
document.querySelector('input[name="origin_zip_code"]').value = addressInfo.postalCode;
// Dispatch 'input' events to ensure other listeners pick up the changes
document.querySelector('input[name="origin_street"]').dispatchEvent(new Event('input'));
document.querySelector('input[name="origin_state"]').dispatchEvent(new Event('input'));
document.querySelector('input[name="origin_city"]').dispatchEvent(new Event('input'));
document.querySelector('input[name="origin_zip_code"]').dispatchEvent(new Event('input'));
}
}
window.addEventListener('load', function() {
var addressInfo = getAddressInfo();
populateAddressFields(addressInfo);
});
autocomplete.addListener('place_changed', fillInAddress);
function fillInAddress() {
var place = autocomplete.getPlace();
var street = '';
var city = '';
var state = '';
var postalCode = '';
place.address_components.forEach(addressComp => {
var addressType = addressComp.types[0];
var val = addressComp[componentForm[addressType]];
if (addressType == "street_number") {
street = val;
} else if (addressType == "route") {
street += " " + val;
} else if (addressType == "locality") {
city = val;
} else if (addressType == "administrative_area_level_1") {
state = val;
} else if (addressType == "origin_zip_code") {
postalCode = val;
}
});
var addressInfo = {
address: street,
city: city,
state: state,
postalCode: postalCode
};
saveAddressInfo(addressInfo);
document.querySelector('input[name="origin_street"]').value = street;
document.querySelector('input[name="origin_state"]').value = city;
document.querySelector('input[name="origin_city"]').value = state;
document.querySelector('input[name="origin_zip_code"]').value = postalCode;
// Dispatch 'input' events to ensure other listeners pick up the changes
document.querySelector('input[name="origin_street"]').dispatchEvent(new Event('input'));
document.querySelector('input[name="origin_state"]').dispatchEvent(new Event('input'));
document.querySelector('input[name="origin_city"]').dispatchEvent(new Event('input'));
document.querySelector('input[name="origin_zip_code"]').dispatchEvent(new Event('input'));
setTimeout(function() {
document.querySelector(".pac-container").style.display = "none";
}, 1000);
}
</script>