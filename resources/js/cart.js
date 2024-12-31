document.addEventListener('alpine:init', () => {
    Alpine.store('cartComponent', {
        cartItems: JSON.parse(localStorage.getItem('cart')) || [], 
        
        saveCart() {
            localStorage.setItem('cart', JSON.stringify(this.cartItems));
        },
        
        getSubtotal() {
            return this.cartItems.reduce((sum, item) => sum + item.sellingPrice * item.quantity, 0);
        },
        
        incrementQuantity(index) {
            // console.log(this.cartItems[index].maxQuantity);
            if(this.cartItems[index].quantity == this.cartItems[index].maxQuantity){
                this.$dispatch('notification', {
                    message : 'We have only ' + this.cartItems[index].maxQuantity + ' items of this type available. Please adjust your quantity or contact us for further assistance.'
                })
                return;
            }
            this.cartItems[index].quantity++;
            this.saveCart();
        },
        
        decrementQuantity(index) {
            if (this.cartItems[index].quantity > 1) {
                this.cartItems[index].quantity--;
            } else {
                this.removeFromCart(index);
            }
            this.saveCart();
        },
        
        removeFromCart(index) {
            this.cartItems.splice(index, 1);
            this.saveCart();
        },
        
        addToCart(product) {
            const existingItemIndex = this.cartItems.findIndex(
                (item) => item.detailId === product.detailId
            );

            if (existingItemIndex > -1) {
                if(this.cartItems[existingItemIndex].quantity + product.quantity > this.cartItems[existingItemIndex].maxQuantity){
                    this.$dispatch('notification', {
                        message : 'We have only ' + this.cartItems[existingItemIndex].maxQuantity + ' items of this type available. Please adjust your quantity in your cart or contact us for further assistance.'
                    })
                    return;
                }
                this.cartItems[existingItemIndex].quantity += product.quantity;
            } else {
                this.cartItems.push(product);
            }

            this.$dispatch('notification', {
                message : 'Item added successfully'
            })
            this.saveCart();
        }
    });

    Alpine.store('showCart', {
        on: false,
        toggle() {
            this.on = !this.on;
        }
    });
    Alpine.store('showMenu', {
        on: false,
        toggle() {
            this.on = !this.on;
        }
    });
});
