//hitung total payment otomatis
function total() {
    var subtotal_room = document.getElementById('subtotal_room').value;
    var additional_cost = document.getElementById('additional_cost').value;
    var discount = document.getElementById('discount').value;
    var total_payment = parseFloat(subtotal_room) + parseFloat(additional_cost) - parseFloat(discount);
    if (!isNaN(total_payment)) {
        document.getElementById('total_payment').value = total_payment;
    }
}
