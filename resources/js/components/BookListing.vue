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

        <!-- Search Bar -->
        <div class="mb-8 flex justify-end">
            <input
                type="text"
                placeholder="Search by book title ..."
                v-model="searchTerm"
                class="w-80 px-4 py-2 rounded border border-gray-300 focus:outline-none focus:border-orange-500"
            />
        </div>

        <!-- Book Table -->
        <div class="bg-white rounded-lg overflow-hidden">
            <table class="w-full">
                <thead>
                    <tr class="bg-slate-900 text-white">
                        <th class="px-6 py-3 text-left">Title</th>
                        <th class="px-6 py-3 text-left">Author</th>
                        <th class="px-6 py-3 text-left">Rating</th>
                        <th class="px-6 py-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="(book, index) in filteredBooks"
                        :key="book.id"
                        :class="[
                            index % 2 === 0 ? 'bg-gray-100' : 'bg-gray-200',
                            'hover:bg-gray-300 transition-colors',
                        ]"
                    >
                        <td class="px-6 py-4">{{ book.title }}</td>
                        <td class="px-6 py-4">{{ book.author }}</td>
                        <td class="px-6 py-4">{{ book.rating }}</td>
                        <td class="px-6 py-4">
                            <div class="space-x-2">
                                <button
                                    @click.stop="editBook(book.id)"
                                    class="text-blue-600 hover:underline"
                                >
                                    Edit
                                </button>

                                <button
                                    @click="deleteBook(book.id)"
                                    class="text-red-600 hover:underline"
                                >
                                    Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            books: [],
            searchTerm: "",
            loading: true,
            error: null,
        };
    },
    created() {
        this.fetchBooks();
    },
    computed: {
        filteredBooks() {
            // Filter books based on the search term
            return this.books.filter((book) =>
                book.title.toLowerCase().includes(this.searchTerm.toLowerCase())
            );
        },
    },
    methods: {
        async fetchBooks() {
            try {
                const response = await fetch("http://localhost:3000/api/books");
                const data = await response.json();
                if (data && data.data) {
                    this.books = data.data;
                } else {
                    this.error = "Failed to fetch books";
                }
            } catch (err) {
                this.error = err.message;
            } finally {
                this.loading = false;
            }
        },
        editBook(bookId) {
            console.log("Edit button clicked, bookId:", bookId);
            if (this.$route.params.id !== bookId.toString()) {
                console.log("Navigating to edit book:", bookId);
                this.$router
                    .push({
                        name: "edit-book",
                        params: { id: bookId },
                    })
                    .then(() => {
                        console.log("Navigation successful");
                    })
                    .catch((err) => {
                        console.error("Navigation error:", err);
                    });
            } else {
                console.log("Already on the same route, navigation skipped.");
            }
        },
        deleteBook(bookId) {
            //this.books = this.books.filter((book) => book.id !== bookId);
            // Make API call to delete the book
            fetch(`http://localhost:3000/api/books/${bookId}`, {
                method: "DELETE",
                headers: {
                    "Content-Type": "application/json",
                },
            })
                .then((response) => response.json())
                .then((data) => {
                    if (
                        data &&
                        data.message === "Successfully deleted the book."
                    ) {
                        this.books = this.books.filter(
                            (book) => book.id !== bookId
                        ); // Update the local book list
                    } else {
                        console.error("Failed to delete the book.");
                    }
                })
                .catch((error) => {
                    console.error("Error:", error);
                });
        },
    },
};
</script>

<style scoped>
/* You can add custom styles here if needed */
</style>
