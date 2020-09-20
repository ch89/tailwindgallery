<template>
	<div class="shadow-md rounded overflow-hidden">
		<div class="relative">
			<img :src="photo.image" alt="Photo" class="w-full">
			<img src="/images/avatar2.jpg" alt="Avatar" class="absolute right-5 transform -translate-y-1/2 w-1/4 rounded-full border-4 border-white">
			<router-link :to="{ query: { channel_id: photo.channel.id } }" class="btn font-bold absolute bottom-5 left-5" :style="{ 'background-color': photo.channel.color }" v-text="photo.channel.name"></router-link>
		</div>
		<div class="p-6">
			<h3 class="font-bold text-lg mb-2">{{ photo.title }}</h3>
			<p class="text-gray-600 truncate mb-3">{{ photo.content }}</p>
			<!-- <button class="btn btn-red btn-sm" @click="remove(photo)">Remove</button> -->

			<div class="flex justify-between items-center">
				<div class="flex items-center">
					<!-- Version 1 -->
					<!-- <a href="#" class="text-gray-500" :class="{ 'text-yellow-500': rating <= photo.rating }" v-for="rating in 5" @click.prevent="rate(rating)">
						<i class="fas fa-star"></i>
					</a> -->

					<!-- Version 2 -->
					<a href="#" :class="rating <= photo.rating ? 'text-star' : 'text-gray-500'" v-for="rating in 5" @click.prevent="rate(rating)">
						<i class="fas fa-star"></i>
					</a>
					<span class="text-gray-600 text-sm ml-1">{{ photo.average }} ({{ photo.ratings_count }} reviews)</span>
				</div>

				<a href="#" class="text-gray-500 hover:text-red-500" :class="{ 'text-red-500': photo.liked }" @click.prevent="like">
					<i class="fas fa-heart"></i> {{ photo.likes_count }}
				</a>
			</div>
		</div>
	</div>
</template>

<script>
	import { mapActions } from "vuex"

	export default {
		props: ["photo"],
		methods: {
			...mapActions(["remove"]),
			async like() {
				await axios.post(`/api/photos/${this.photo.id}/like`)

				this.photo.liked = ! this.photo.liked
				this.photo.liked ? this.photo.likes_count++ : this.photo.likes_count--
			},
			async rate(rating) {
				await axios.post(`/api/photos/${this.photo.id}/rate`, { rating })

				this.photo.rating = rating
			}
		}
	}
</script>