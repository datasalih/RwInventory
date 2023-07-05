
  // Arama kutusu elementini seçin
  var searchInput = document.getElementById('search-input');

  // Her tuşa basıldığında arama işlemini gerçekleştirin
  searchInput.addEventListener('keyup', function() {
    var searchValue = this.value.toLowerCase(); // Arama metnini küçük harflere çevirin

    // Tablodaki her satırı döngüyle kontrol edin
    var rows = document.querySelectorAll('table tbody tr');
    for (var i = 0; i < rows.length; i++) {
      var productName = rows[i].querySelector('td:nth-child(2)').textContent.toLowerCase(); // Ürün adını alın ve küçük harflere çevirin

      // Arama metni, ürün adı içeriyorsa satırı gösterin, aksi halde gizleyin
      if (productName.includes(searchValue)) {
        rows[i].style.display = 'table-row';
      } else {
        rows[i].style.display = 'none';
      }
    }
  });
