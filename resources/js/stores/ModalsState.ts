import { Uploadable } from "@/components/modals/UploadPanel.vue";

import { defineStore } from "pinia";

export type TogglablesStateStore = ReturnType<typeof useTogglablesStateStore>;

export const useTogglablesStateStore = defineStore("togglables-store", {
	state: () => ({
		// togglables
		left_menu_open: false,
		is_full_screen: false,
		is_login_open: false,

		// upload
		is_upload_visible: false,
		list_upload_files: [] as Uploadable[],

		// create albums
		is_create_album_visible: false,
		is_create_tag_album_visible: false,

		// Photo toggleables
		is_edit_open: false,
		are_details_open: false,
		is_slideshow_active: false,

		// Search stuff
		search_term: "",
		search_album_id: undefined as string | undefined,
		search_page: 1,

		// Scroll memory
		scroll_memory: {} as Record<string, number>,
	}),
	getters: {
		isSearchActive(): boolean {
			return this.search_term !== "";
		},
	},
	actions: {
		toggleFullScreen() {
			this.is_full_screen = !this.is_full_screen;
		},

		toggleLogin() {
			this.is_login_open = !this.is_login_open;
		},

		toggleLeftMenu() {
			this.left_menu_open = !this.left_menu_open;
		},

		resetSearch() {
			this.search_term = "";
			this.search_album_id = undefined;
			this.search_page = 1;
		},

		rememberScrollPage(elem: HTMLElement, path: string) {
			this.scroll_memory[path] = elem.scrollTop;
		},

		recoverScrollPage(elem: HTMLElement, path: string) {
			if (!(path in this.scroll_memory)) {
				return;
			}
			const scroll = this.scroll_memory[path];
			if (scroll) {
				elem.scrollTop = scroll;
				// Smooth scrolling
				// elem.scrollTo({
				// 	top: scroll,
				// 	behavior: "smooth",
				// });
			}
		},
	},
});
