<template>
    <div>
        <div class="bg-gray-800 pt-8 pb-20">
            <div class="w-9/12 text-center mr-auto ml-auto -mt-0 mb-0">
                <h1 class="text-orange text-5xl p-10">Book Shop</h1>
                <p class="w-9/12 mr-auto ml-auto -mt-0 mb-0 text-white">
                    Cupcake ipsum dolor sit amet croissant. I love topping candy
                    canes sweet roll croissant caramels. Soufflé macaroon
                    liquorice chocolate tart I love.
                </p>
            </div>
        </div>
        <div class="w-1/5 text-left mr-auto ml-auto -mt-0 mb-0">
            <form @submit.prevent="submit">
                <div class="pt-10">
                    <h2 class="text-center text-3xl pb-10">Edit Book</h2>
                    <div class="pb-10">
                        <label class="w-20 inline-block">Title: </label>
                        <input
                            v-model="book.title"
                            type="text"
                            placeholder="Title"
                            class="rounded-md border-gray-400 border-solid border-[1px] p-2 w-96"
                        />
                    </div>
                    <div class="pb-10">
                        <label class="w-20 inline-block">Author: </label>
                        <input
                            type="text"
                            v-model="book.author"
                            placeholder="Author"
                            class="rounded-md border-gray-400 border-solid border-[1px] p-2 w-96"
                        />
                    </div>
                    <div class="pb-10">
                        <label class="w-20 inline-block">Rating: </label>
                        <input
                            type="text"
                            v-model="book.rating"
                            placeholder="5"
                            class="rounded-md border-gray-400 border-solid border-[1px] p-2 w-96"
                        />
                    </div>
                </div>
                <div class="text-center">
                    <button
                        class="text-white bg-orange py-2 px-4 rounded"
                        type="submit"
                    >
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    name: "EditBook",
    data() {
        return {
            book: {
                id: null,
                title: "",
                author: "",
                rating: "",
            },
        };
    },
    created() {
        this.fetchBook();
    },
    methods: {
        async fetchBook() {
            const bookId = this.$route.params.id;
            try {
                const response = await fetch(
                    `http://localhost:3000/api/books/${bookId}`
                );
                const data = await response.json();
                this.book = data;
            } catch (error) {
                console.error("Error fetching book:", error);
            }
        },

        async submit() {
            try {
                const response = await fetch(
                    `http://localhost:3000/api/books/${this.book.id}`,
                    {
                        method: "PUT",
                        headers: {
                            "Content-Type": "application/json",
                        },
                        body: JSON.stringify(this.book),
                    }
                );
                const data = await response.json();
                console.log(data);
                if (data && data.message === "Successfully updated the book.") {
                    console.log("testing");
                    this.$router.push("/");
                } else {
                    console.error("Failed to update the book.");
                }
            } catch (error) {
                console.error("Error:", error);
            }
        },
    },
};
</script>
