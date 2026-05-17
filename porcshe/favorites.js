function removeFavorite(button) {
    const favoriteItem = button.closest('.favorite-item');
    favoriteItem.remove();
    alert('Item removed from favorites!');
  }