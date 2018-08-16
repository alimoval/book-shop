new Vue({
    el: '#app',
    data: {
        cars: []
    },
    created() {
        this.fetchCars();
    },
    methods: {
        fetchCars: function () {
            fetch('http://192.168.0.15/~user16/rest/client/api/cars')
                .then((response) => {
                    if (response.ok) {
                        return response.json();
                    }
                    throw new Error('Network response was not ok');
                })
                .then((json) => {
                    json['data'].forEach(item => {
                        this.cars.push({
                            id: item.id,
                            model: item.model,
                            tm: item.tm,
                            price: item.price,
                            images: item.images
                        });
                    });
                })
                .catch((error) => {
                    console.log(error);
                });
        }
    }
});