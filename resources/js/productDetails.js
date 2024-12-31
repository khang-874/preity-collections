document.addEventListener('alpine:init', () => {
    Alpine.data('productDetails', (initSizes, initColors, initListingId, initName, initBasePrice, initSellingPrice, initSalePercentage, initImageUrl) => ({
        sizes : initSizes,
        colors : initColors,
        listingId : initListingId,
        name : initName,
        basePrice : initBasePrice,
        sellingPrice : initSellingPrice,
        salePercentage : initSalePercentage,
        imageUrl : initImageUrl,
        size: '',
        color: '',
        quantity: 1,
        handleClick() {
            if(this.size == '' || this.color == ''){
                this.$dispatch('notification', {
                    message : 'Please choose your size and color'
                });
                return;
            }
            let maxQuantity = this.sizes[this.size][this.color]['quantity'];
            if(this.quantity > maxQuantity){
                this.quantity = maxQuantity;
                this.$dispatch('notification', {
                    message : 'We have only ' + maxQuantity + ' items of this type available. Please adjust your quantity or contact us for further assistance.'
                })
                return;
            }
            console.log(this.$store);
            // console.log($store.showMenu);
            this.$store.cartComponent.addToCart({
                listingId : this.listingId,
                detailId: this.sizes[this.size][this.color]['detailId'],
                maxQuantity : this.sizes[this.size][this.color]['quantity'],
                name: this.name,
                color: this.color,
                size: this.size,
                quantity: this.quantity,
                sellingPrice: this.sellingPrice,
                basePrice: this.basePrice,
                salePercentage : this.salePercentage,
                imageURL: this.imageUrl,
            });
        },

        showAvailableOptions(mainOption, otherOption) { 
            let mainOptionObj = this[mainOption  + 's'];
            let mainOptionContainer = this.$refs[mainOption + 'Container'];
            let otherOptionContainer = this.$refs[otherOption + 'Container'];
            let mainOptionValue = this[mainOption];

            for(let i = 0; i < mainOptionContainer.children.length; ++i){
                let divContainer = mainOptionContainer.children[i];
                divContainer.classList.remove('opacity-50');
            }

            for(let i = 0; i < otherOptionContainer.children.length; ++i){
                let divContainer = otherOptionContainer.children[i];
                let inputValue = otherOptionContainer.children[i].children[0].value;

                if(mainOptionObj[mainOptionValue].hasOwnProperty(inputValue)){
                    divContainer.classList.remove('opacity-50');
                }else{
                    divContainer.classList.add('opacity-50');
                }
            }

            for(let i = 0; i < otherOptionContainer.children.length; ++i){
                let inputValue = otherOptionContainer.children[i].children[0].value;
                if(mainOptionObj[mainOptionValue].hasOwnProperty(inputValue)){
                    this[otherOption] = inputValue;
                    break
                }
            }

        },
    }));
});