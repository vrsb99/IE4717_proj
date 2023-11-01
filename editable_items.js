let sizeIndex;

document.addEventListener("DOMContentLoaded", function() {
  getSizeIndex();
});

function getSizeIndex() {
    let i = 1;
    while (document.getElementById('size_id_' + i)) {
      i++;
    }
    sizeIndex = i;
}

function addSizeRow() {
  const tbody = document.getElementById('sizeTableBody');

  const newRow = document.createElement('tr');
  const nameCell = document.createElement('td');
  const priceCell = document.createElement('td');
  const quantityCell = document.createElement('td');

  nameCell.innerHTML = `<input style='width:50px;text-align:center' type='text' required name='size_name_${sizeIndex}'">`;
  priceCell.innerHTML = `<input style='width:50px;text-align:center' type='number' required min='0' step='0.01' name='price_${sizeIndex}' onchange="numericValidation(this)">`;
  quantityCell.innerHTML = `<input style='width:50px;text-align:center' type='number' min='0' name='quantity_${sizeIndex}' onchange="numericValidation(this)>`;

  newRow.appendChild(nameCell);
  newRow.appendChild(priceCell);
  newRow.appendChild(quantityCell);
  tbody.appendChild(newRow);
  
  sizeIndex++;
}

function numericValidation(input) {
  if (input.value < 0) {
    input.value = 0;
  }
}
