(()=> {

const looksLikeChrome = !!(window.chrome && (chrome.loadTimes || chrome.csi));
// NOTE: Microsoft Edge includes window.chrome.app
// (also this browser detection logic could likely use some more nuance)

window.menus = {
	"&File": [
		{
			item: "&New",
			shortcut: "Ctrl+Alt+N", // Ctrl+N opens a new browser window
			speech_recognition: [
				"new", "new file", "new document", "create new document", "create a new document", "start new document", "start a new document",
			],
			action: ()=> { file_new(); },
			description: "Creates a new document.",
		},
		{
			item: "&Publish",
			shortcut: "Ctrl+Alt+P",
			action: ()=> { file_publish(); },
			description: "Publishes your creation to your Arcader profile.",
		},
		/*{
			item: "&Open",
			shortcut: "Ctrl+O",
			speech_recognition: [
				"open", "open document", "open file", "open an image file", "open a document", "open a file",
				"load document", "load a document", "load an image file", "load an image",
				"show file picker", "show file chooser", "show file browser", "show finder",
				"browser for file", "browse for a file", "browse for an image", "browse for an image file",
			],
			action: ()=> { file_open(); },
			description: "Opens an existing document.",
		},
		{
			item: "&Save",
			shortcut: "Ctrl+S",
			speech_recognition: [
				"save", "save document", "save file", "save image", "save picture", "save image file",
				// "save a document", "save a file", "save an image", "save an image file", // too "save as"-like
				"save the document", "save the file", "save the image", "save the image file",
			],
			action: ()=> { file_save(); },
			description: "Saves the active document.",
		},
		{
			item: "Save &As",
			shortcut: "Ctrl+Shift+S",
			speech_recognition: [
				// this is ridiculous
				// this would be really simple in JSGF format
				"save as", "save as a new file", "save as a new picture", "save as a new image", "save a new file", "save new file",
				"save a new document", "save a new image file", "save a new image", "save a new picture",
				"save as a copy", "save a copy", "save as copy", "save under a new name", "save with a new name",
				"save document as a copy", "save document copy", "save document as copy", "save document under a new name", "save document with a new name",
				"save image as a copy", "save image copy", "save image as copy", "save image under a new name", "save image with a new name",
				"save file as a copy", "save file copy", "save file as copy", "save file under a new name", "save file with a new name",
				"save image file as a copy", "save image file copy", "save image file as copy", "save image file under a new name", "save image file with a new name",
			],
			// in mspaint, no shortcut is listed; it supports F12 (but in a browser that opens the dev tools)
			// it doesn't support Ctrl+Shift+S but that's a good & common modern shortcut
			action: ()=> { file_save_as(); },
			description: "Saves the active document with a new name.",
		},
		MENU_DIVIDER,
		{
			item: "&Load From URL",
			// shortcut: "Ctrl+L",
			speech_recognition: [
				"load from url",
				"load from a url",
				"load from address",
				"load from an address",
				"load from a web address",
				// this is ridiculous
				// this would be really simple in JSGF format
				"load an image from a URL",
				"load an image from an address",
				"load an image from a web address",
				"load image from a URL",
				"load image from an address",
				"load image from a web address",
				"load an image from URL",
				"load an image from address",
				"load an image from web address",
				"load image from URL",
				"load image from address",
				"load image from web address",

				"load an picture from a URL",
				"load an picture from an address",
				"load an picture from a web address",
				"load picture from a URL",
				"load picture from an address",
				"load picture from a web address",
				"load an picture from URL",
				"load an picture from address",
				"load an picture from web address",
				"load picture from URL",
				"load picture from address",
				"load picture from web address",
			],
			action: ()=> { file_load_from_url(); },
			description: "Opens an image from the web.",
		},
		{
			item: "&Upload To Imgur",
			speech_recognition: [
				"upload to imgur", "upload image to imgur", "upload picture to imgur",
			],
			action: ()=> {
				// include the selection in the saved image
				deselect();

				canvas.toBlob((blob)=> {
					sanity_check_blob(blob, ()=> {
						show_imgur_uploader(blob);
					});
				});
			},
			description: "Uploads the active document to Imgur",
		},
		MENU_DIVIDER,
		{
			item: "Manage Storage",
			speech_recognition: [
				"manage storage", "show storage", "open storage window", "manage sessions", "show sessions", "storage manager", "show storage manager", "open storage manager",
			],
			action: ()=> { manage_storage(); },
			description: "Manages storage of previously created or opened pictures.",
		},
		MENU_DIVIDER,
		{
			item: "Print Pre&view",
			speech_recognition: [
				"preview print", "print preview", "show print preview", "show preview of print",
			],
			action: ()=> {
				print();
			},
			description: "Prints the active document and sets printing options.",
			//description: "Displays full pages.",
		},
		{
			item: "Page Se&tup",
			speech_recognition: [
				"setup page for print", "setup page for printing", "set-up page for print", "set-up page for printing", "set up page for print", "set up page for printing",
				"page setup", "printing setup", "page set-up", "printing set-up", "page set up", "printing set up",
			],
			action: ()=> {
				print();
			},
			description: "Prints the active document and sets printing options.",
			//description: "Changes the page layout.",
		},
		{
			item: "&Print",
			shortcut: "Ctrl+P",
			speech_recognition: [
				"print", "send to printer", "show print dialog",
				"print page", "print image", "print picture", "print drawing",
				"print out page", "print out image", "print out picture", "print out drawing", 
				"print out the page", "print out the image", "print out the picture", "print out the drawing", 

				"send page to printer", "send image to printer", "send picture to printer", "send drawing to printer", 
				"send page to the printer", "send image to the printer", "send picture to the printer", "send drawing to the printer", 
				"send the page to the printer", "send the image to the printer", "send the picture to the printer", "send the drawing to the printer", 
				"send the page to printer", "send the image to printer", "send the picture to printer", "send the drawing to printer", 
			],
			action: ()=> {
				print();
			},
			description: "Prints the active document and sets printing options.",
		},
		MENU_DIVIDER,
		{
			item: "Set As &Wallpaper (Tiled)",
			speech_recognition: [
				"set as wallpaper",
				"set as wallpaper tiled",
				"set image as wallpaper tiled", "set picture as wallpaper tiled", "set drawing as wallpaper tiled", 
				"use as wallpaper tiled",
				"use image as wallpaper tiled", "use picture as wallpaper tiled", "use drawing as wallpaper tiled", 
				"tile image as wallpaper", "tile picture as wallpaper", "tile drawing as wallpaper", 
			],
			action: ()=> { set_as_wallpaper_tiled(); },
			description: "Tiles this bitmap as the desktop background.",
		},
		{
			item: "Set As Wallpaper (&Centered)", // in mspaint it's Wa&llpaper
			speech_recognition: [
				"set as wallpaper centered",
				"set image as wallpaper centered", "set picture as wallpaper centered", "set drawing as wallpaper centered", 
				"use as wallpaper centered",
				"use image as wallpaper centered", "use picture as wallpaper centered", "use drawing as wallpaper centered", 
				"center image as wallpaper", "center picture as wallpaper", "center drawing as wallpaper", 
			],
			action: ()=> { set_as_wallpaper_centered(); },
			description: "Centers this bitmap as the desktop background.",
		},
		MENU_DIVIDER,
		{
			item: "Recent File",
			enabled: false, // @TODO for desktop app
			description: "",
		},
		MENU_DIVIDER,
		{
			item: "E&xit",
			// shortcut: "Alt+F4", // closes browser window
			speech_recognition: [
				"exit application", "exit paint", "close paint window",
			],
			action: ()=> {
				close();
			},
			description: "Quits Paint.",
		}*/
	],
	"&Edit": [
		{
			item: "&Undo",
			shortcut: "Ctrl+Z",
			speech_recognition: [
				"undo", "undo that",
			],
			enabled: () => undos.length >= 1,
			action: ()=> { undo(); },
			description: "Undoes the last action.",
		},
		{
			item: "&Repeat",
			shortcut: "F4",
			speech_recognition: [
				"repeat", "redo",
			],
			enabled: () => redos.length >= 1,
			action: ()=> { redo(); },
			description: "Redoes the previously undone action.",
		},
		{
			item: "&History",
			shortcut: "Ctrl+Shift+Y",
			speech_recognition: [
				"show history", "history",
			],
			action: ()=> { show_document_history(); },
			description: "Shows the document history and lets you navigate to states not accessible with Undo or Repeat.",
		},
		MENU_DIVIDER,
		{
			item: "Cu&t",
			shortcut: "Ctrl+X",
			speech_recognition: [
				"cut", "cut selection", "cut selection to clipboard", "cut the selection", "cut the selection to clipboard", "cut the selection to the clipboard",
			],
			enabled: () =>
				// @TODO: support cutting text with this menu item as well (e.g. for the text tool)
				!!selection,
			action: ()=> {
				edit_cut(true);
			},
			description: "Cuts the selection and puts it on the Clipboard.",
		},
		{
			item: "&Copy",
			shortcut: "Ctrl+C",
			speech_recognition: [
				"copy", "copy selection", "copy selection to clipboard", "copy the selection", "copy the selection to clipboard", "copy the selection to the clipboard",
			],
			enabled: () =>
				// @TODO: support copying text with this menu item as well (e.g. for the text tool)
				!!selection,
			action: ()=> {
				edit_copy(true);
			},
			description: "Copies the selection and puts it on the Clipboard.",
		},
		{
			item: "&Paste",
			shortcut: "Ctrl+V",
			speech_recognition: [
				"paste", "paste from clipboard", "paste from the clipboard", "insert clipboard", "insert clipboard contents", "insert the contents of the clipboard", "paste what's on the clipboard",
			],
			enabled: () =>
				// @TODO: disable if nothing in clipboard or wrong type (if we can access that)
				true,
			action: ()=> {
				edit_paste(true);
			},
			description: "Inserts the contents of the Clipboard.",
		},
		{
			item: "C&lear Selection",
			shortcut: "Del",
			speech_recognition: [
				"delete", "clear selection", "delete selection", "delete selected", "delete selected area", "clear selected area", "erase selected", "erase selected area",
			],
			enabled: () => !!selection,
			action: ()=> { delete_selection(); },
			description: "Deletes the selection.",
		},
		{
			item: "Select &All",
			shortcut: "Ctrl+A",
			speech_recognition: [
				"select all", "select everything",
				"select the whole image", "select the whole picture", "select the whole drawing", "select the whole canvas", "select the whole document",
				"select the entire image", "select the entire picture", "select the entire drawing", "select the entire canvas", "select the entire document",
			],
			action: ()=> { select_all(); },
			description: "Selects everything.",
		}/*,
		MENU_DIVIDER,
		{
			item: "C&opy To...",
			speech_recognition: [
				"copy to file", "copy selection to file", "copy selection to a file", "save selection", 
				"save selection as file", "save selection as image", "save selection as picture", "save selection as image file", "save selection as document",
				"save selection as a file", "save selection as a image", "save selection as a picture", "save selection as a image file", "save selection as a document",
				"save selection to file", "save selection to image", "save selection to picture", "save selection to image file", "save selection to document",
				"save selection to a file", "save selection to a image", "save selection to a picture", "save selection to a image file", "save selection to a document",
			],
			enabled: () => !!selection,
			action: ()=> { save_selection_to_file(); },
			description: "Copies the selection to a file.",
		},
		{
			item: "Paste &From...",
			speech_recognition: [
				"paste a file", "paste from a file", "insert a file", "insert an image file", 
			],
			action: ()=> { paste_from_file_select_dialog(); },
			description: "Pastes a file into the selection.",
		}*/
	],
	"&View": [
		{
			item: "&Tool Box",
			// shortcut: "Ctrl+T", // opens a new browser tab
			speech_recognition: [
				"toggle tool box", "toggle tools box", "toggle toolbox", "toggle tool palette", "toggle tools palette",
				// @TODO: hide/show
			],
			checkbox: {
				toggle: ()=> {
					$toolbox.toggle();
				},
				check: () => $toolbox.is(":visible"),
			},
			description: "Shows or hides the tool box.",
		},
		{
			item: "&Color Box",
			// shortcut: "Ctrl+L", // focuses browser address bar
			speech_recognition: [
				"toggle color box", "toggle colors box", "toggle palette", "toggle color palette", "toggle colors palette",
				// @TODO: hide/show
			],
			checkbox: {
				toggle: ()=> {
					$colorbox.toggle();
				},
				check: () => $colorbox.is(":visible"),
			},
			description: "Shows or hides the color box.",
		},
		{
			item: "&Status Bar",
			speech_recognition: [
				"toggle status bar", "toggle status text", "toggle status area", "toggle status indicator",
				// @TODO: hide/show
			],
			checkbox: {
				toggle: ()=> {
					$status_area.toggle();
				},
				check: () => $status_area.is(":visible"),
			},
			description: "Shows or hides the status bar.",
		},
		{
			item: "T&ext Toolbar",
			speech_recognition: [
				"toggle text toolbar", "toggle font toolbar", "toggle text tool bar", "toggle font tool bar",
				"toggle font box", "toggle fonts box", "toggle text options box", "toggle text tool options box", "toggle font options box",
				"toggle font window", "toggle fonts window", "toggle text options window", "toggle text tool options window", "toggle font options window",
				// @TODO: hide/show
			],
			enabled: false, // @TODO: toggle fonts box
			checkbox: {},
			description: "Shows or hides the text toolbar.",
		},
		MENU_DIVIDER,
		{
			item: "&Zoom",
			submenu: [
				{
					item: "&Normal Size",
					// shortcut: "Ctrl+PgUp", // cycles thru browser tabs
					speech_recognition: [
						"reset zoom", "zoom to normal size",
						"zoom to 100%", "set zoom to 100%", "set zoom 100%",
						"zoom to 1x", "set zoom to 1x", "set zoom 1x",
						"zoom level to 100%", "set zoom level to 100%", "set zoom level 100%",
						"zoom level to 1x", "set zoom level to 1x", "set zoom level 1x",
					],
					description: "Zooms the picture to 100%.",
					enabled: () => magnification !== 1,
					action: ()=> {
						set_magnification(1);
					},
				},
				{
					item: "&Large Size",
					// shortcut: "Ctrl+PgDn", // cycles thru browser tabs
					speech_recognition: [
						"zoom to large size",
						"zoom to 400%", "set zoom to 400%", "set zoom 400%",
						"zoom to 4x", "set zoom to 4x", "set zoom 4x",
						"zoom level to 400%", "set zoom level to 400%", "set zoom level 400%",
						"zoom level to 4x", "set zoom level to 4x", "set zoom level 4x",
					],
					description: "Zooms the picture to 400%.",
					enabled: () => magnification !== 4,
					action: ()=> {
						set_magnification(4);
					},
				},
				{
					item: "Zoom To &Window",
					speech_recognition: [
						"zoom to window", "zoom to view",
						"zoom to fit",
						"zoom to fit within window", "zoom to fit within view",
						"zoom to fit within the window", "zoom to fit within the view",
						"zoom to fit in window", "zoom to fit in view",
						"zoom to fit in the window", "zoom to fit in the view",
						"auto zoom", "fit zoom",
						"zoom to max", "zoom to maximum", "zoom to max size", "zoom to maximum size",
						"zoom so canvas fits", "zoom so picture fits", "zoom so image fits", "zoom so document fits",
						"zoom so whole canvas is visible", "zoom so whole picture is visible", "zoom so whole image is visible", "zoom so whole document is visible",
						"zoom so the whole canvas is visible", "zoom so the whole picture is visible", "zoom so the whole image is visible", "zoom so the whole document is visible",
						
						"fit to window", "fit to view", "fit in window", "fit in view", "fit within window", "fit within view",
						"fit picture to window", "fit picture to view", "fit picture in window", "fit picture in view", "fit picture within window", "fit picture within view",
						"fit image to window", "fit image to view", "fit image in window", "fit image in view", "fit image within window", "fit image within view",
						"fit canvas to window", "fit canvas to view", "fit canvas in window", "fit canvas in view", "fit canvas within window", "fit canvas within view",
						"fit document to window", "fit document to view", "fit document in window", "fit document in view", "fit document within window", "fit document within view",
					],
					description: "Zooms the picture to fit within the view.",
					action: ()=> {
						const rect = $canvas_area[0].getBoundingClientRect();
						const margin = 30; // leave a margin so scrollbars won't appear
						let mag = Math.min(
							(rect.width - margin) / canvas.width,
							(rect.height - margin) / canvas.height,
						);
						// round to an integer percent for the View > Zoom > Custom... dialog, which shows non-integers as invalid
						mag = Math.floor(100 * mag) / 100;
						set_magnification(mag);
					},
				},
				{
					item: "C&ustom...",
					description: "Zooms the picture.",
					speech_recognition: [
						"zoom custom", "custom zoom", "set custom zoom", "set custom zoom level", "zoom to custom level", "zoom to custom", "zoom level", "set zoom level",
					],
					action: ()=> { show_custom_zoom_window(); },
				},
				MENU_DIVIDER,
				{
					item: "Show &Grid",
					shortcut: "Ctrl+G",
					speech_recognition: [
						"toggle show grid",
						"toggle grid", "toggle gridlines", "toggle grid lines", "toggle grid cells",
						// @TODO: hide/show
					],
					enabled: () => magnification >= 4,
					checkbox: {
						toggle: toggle_grid,
						check: () => show_grid,
					},
					description: "Shows or hides the grid.",
				}/*,
				{
					item: "Show T&humbnail",
					speech_recognition: [
						"toggle show thumbnail",
						"toggle thumbnail", "toggle thumbnail view", "toggle thumbnail box", "toggle thumbnail window",
						"toggle preview", "toggle image preview", "toggle picture preview",
						"toggle picture in picture", "toggle picture in picture view", "toggle picture in picture box", "toggle picture in picture window",
						// @TODO: hide/show
					],
					enabled: false, // @TODO: implement Show Thumbnail
					checkbox: {},
					description: "Shows or hides the thumbnail view of the picture.",
				}*/
			]
		}/*,
		{
			item: "&View Bitmap",
			shortcut: "Ctrl+F",
			speech_recognition: [
				"view bitmap", "show bitmap",
				"fullscreen", "full-screen", "full screen",
				"show picture fullscreen", "show picture full-screen", "show picture full screen",
				"show image fullscreen", "show image full-screen", "show image full screen",
				// @TODO: exit fullscreen
			],
			action: ()=> { view_bitmap(); },
			description: "Displays the entire picture.",
		}*/
	],
	"&Image": [
		// @TODO: speech recognition: terms that apply to selection
		{
			item: "&Flip/Rotate",
			// shortcut: "Ctrl+R", // reloads browser tab
			speech_recognition: [
				"flip",
				"rotate",
				"flip/rotate", "flip slash rotate", "flip and rotate", "flip or rotate", "flip rotate",
				// @TODO: parameters to command
			],
			action: ()=> { image_flip_and_rotate(); },
			description: "Flips or rotates the picture or a selection.",
		},
		{
			item: "&Stretch/Skew",
			// shortcut: "Ctrl+W", // closes browser tab
			speech_recognition: [
				"stretch", "scale", "resize image",
				"skew",
				"stretch/skew", "stretch slash skew", "stretch and skew", "stretch or skew", "stretch skew",
				// @TODO: parameters to command
			],
			action: ()=> { image_stretch_and_skew(); },
			description: "Stretches or skews the picture or a selection.",
		},
		{
			item: "&Invert Colors",
			shortcut: "Ctrl+I",
			speech_recognition: [
				"invert",
				"invert colors",
				"invert image", "invert picture", "invert drawing",
				"invert image colors", "invert picture colors", "invert drawing colors",
				"invert colors of image", "invert colors of picture", "invert colors of drawing",
			],
			action: ()=> { image_invert_colors(); },
			description: "Inverts the colors of the picture or a selection.",
		},
		{
			item: "&Attributes...",
			shortcut: "Ctrl+E",
			speech_recognition: [
				"attributes", "image attributes", "picture attributes", "image options", "picture options",
				"dimensions", "image dimensions", "picture dimensions",
				"resize canvas", "resize document", "resize page", // not resize image/picture because that implies scaling, handled by Stretch/Skew
				"set image size", "set picture size", "set canvas size", "set document size", "set page size",
				"image size", "picture size", "canvas size", "document size", "page size",
				"configure image size", "configure picture size", "configure canvas size", "configure document size", "configure page size",
			],
			action: ()=> { image_attributes(); },
			description: "Changes the attributes of the picture.",
		},
		{
			item: "&Clear Image",
			shortcut: looksLikeChrome ? undefined : "Ctrl+Shift+N", // opens incognito window in chrome
			speech_recognition: [
				"clear image", "clear canvas", "clear picture", "clear page", "clear drawing",
				// @TODO: erase?
			],
			// (mspaint says "Ctrl+Shft+N")
			action: ()=> { !selection && clear(); },
			enabled: ()=> !selection,
			description: "Clears the picture.",
			// action: ()=> {
			// 	if (selection) {
			// 		delete_selection();
			// 	} else {
			// 		clear();
			// 	}
			// },
			// mspaint says "Clears the picture or selection.", but grays out the option when there's a selection
		},
		{
			item: "&Draw Opaque",
			speech_recognition: [
				"toggle draw opaque",
				"toggle transparent selection", "toggle transparent selections",
				"toggle transparent selection mode", "toggle transparent selections mode",
				"toggle opaque selection", "toggle opaque selections",
				"toggle opaque selection mode", "toggle opaque selections mode",
				// toggle opaque? toggle opacity?
				// @TODO: hide/show / "draw opaque" / "draw transparent"/translucent?
			],
			checkbox: {
				toggle: ()=> {
					tool_transparent_mode = !tool_transparent_mode;
					$G.trigger("option-changed");
				},
				check: () => !tool_transparent_mode,
			},
			description: "Makes the current selection either opaque or transparent.",
		}
	],
	"&Colors": [
		{
			item: "&Edit Colors...",
			speech_recognition: [
				"edit colors", "edit color", "edit custom colors", "edit custom color",
				"pick custom color", "choose custom color", "pick a custom color", "choose a custom color",
				"edit last color", "create new color", "choose new color", "create a new color", "pick a new color",
			],
			action: ()=> {
				$colorbox.edit_last_color();
			},
			description: "Creates a new color.",
		},
		{
			item: "&Get Colors",
			speech_recognition: [
				"get colors", "load colors", "load color palette", "load palette", "load color palette file", "load palette file", "load list of colors",
			],
			action: ()=> {
				get_FileList_from_file_select_dialog((files)=> {
					const file = files[0];
					Palette.load(file, (err, new_palette)=> {
						if(err){
							show_error_message("This file is not in a format that paint recognizes, or no colors were found.");
						}else{
							palette = new_palette;
							$colorbox.rebuild_palette();
						}
					});
				});
			},
			description: "Uses a previously saved palette of colors.",
		},
		{
			item: "&Save Colors",
			speech_recognition: [
				"save colors", "save list of colors", "save color palette", "save palette", "save color palette file", "save palette file",
			],
			action: ()=> {
				const blob = new Blob([JSON.stringify(palette)], {type: "application/json"});
				sanity_check_blob(blob, ()=> {
					saveAs(blob, "colors.json");
				});
			},
			description: "Saves the current palette of colors to a file.",
		}
	],
	"&Help": [
		/*{
			item: "&Help Topics",
			speech_recognition: [
				"help topics", "help me", "show help", "help", "show help window", "show help topics", "open help",
				"help viewer", "show help viewer", "open help viewer",
			],
			action: ()=> { show_help(); },
			description: "Displays Help for the current task or command.",
		},
		MENU_DIVIDER,*/
		{
			item: "&About",
			speech_recognition: [
				"about paint", "about js paint", "about jspaint", "show about window", "open about window", "about window",
				"app info", "about the app", "app information", "information about the app",
				"application info", "about the application", "application information", "information about the application",
				"who made this", "who did this", "who did this xd",
			],
			action: ()=> { show_about_paint(); },
			description: "Displays information about this application.",
			//description: "Displays program information, version number, and copyright.",
		}
	],
	"E&xtras": [
		{
			item: "&History",
			shortcut: "Ctrl+Shift+Y",
			speech_recognition: [
				// This is a duplicate menu item (for easy access), so it doesn't need speech recognition data here.
			],
			action: ()=> { show_document_history(); },
			description: "Shows the document history and lets you navigate to states not accessible with Undo or Repeat.",
		},
		/*{
			item: "&Render History As GIF",
			shortcut: "Ctrl+Shift+G",
			speech_recognition: [
				// @TODO: animated gif, blah
				"render history as gif", "render history as a gif", "render history animation", "make history animation", "make animation of history", "make animation of document history", "make animation from document history",
				"render a gif from the history", "render a gif animation from the history", "render an animation from the history",
				"make a gif from the history", "make a gif animation from the history", "make an animation from the history",
				"create a gif from the history", "create a gif animation from the history", "create an animation from the history",
				// aaaaaaaaaaaaaaaaaaaaaaaaaa *exponentially explodes*
				"make a gif", "make a gif of the history", "make a gif of the document history", "make a gif from the document history",
				"create a gif", "create a gif of the history", "create a gif of the document history", "create a gif from the document history",
				"make gif", "make gif of the history", "make gif of the document history", "make gif from the document history",
				"create gif", "create gif of the history", "create gif of the document history", "create gif from the document history",
				"make an animation", "make an animation of the history", "make an animation of the document history", "make an animation from the document history",
				"create an animation", "create an animation of the history", "create an animation of the document history", "create an animation from the document history",
				"make animation", "make animation of the history", "make animation of the document history", "make animation from the document history",
				"create animation", "create animation of the history", "create animation of the document history", "create animation from the document history",
			],
			action: ()=> { render_history_as_gif(); },
			description: "Creates an animation from the document history.",
		},
		// {
		// 	item: "Render History as &APNG",
		// 	// shortcut: "Ctrl+Shift+A",
		// 	action: ()=> { render_history_as_apng(); },
		// 	description: "Creates an animation from the document history.",
		// },
		MENU_DIVIDER,
		// {
		// 	item: "Extra T&ool Box",
		// 	checkbox: {
		// 		toggle: ()=> {
		// 			// this doesn't really work well at all to have two toolboxes
		// 			// (this was not the original plan either)
		// 			$toolbox2.toggle();
		// 		},
		// 		check: ()=> {
		// 			return $toolbox2.is(":visible");
		// 		},
		// 	},
		// 	description: "Shows or hides an extra tool box.",
		// },
		// {
		// 	item: "&Preferences",
		// 	action: ()=> {
		// 		// :)
		// 	},
		// 	description: "Configures JS Paint.",
		// }
		{
			item: "&Draw Randomly",
			speech_recognition: [
				"draw randomly", "draw pseudorandomly", "draw wildly", "make random art",
			],
			checkbox: {
				toggle: ()=> {
					if (window.simulatingGestures) {
						stopSimulatingGestures();
					} else {
						simulateRandomGesturesPeriodically();
					}
				},
				check: ()=> {
					return window.simulatingGestures;
				},
			},
			description: "Draws randomly with different tools.",
		},*/
		/*{
			item: "&Multi-User",
			submenu: [
				{
					item: "&New Session From Document",
					speech_recognition: [
						"new session from document",
						"session from document",
						"online session",
						"enable multi-user",
						"enable multiplayer",
						"start multi-user",
						"start multiplayer",
						"start collaboration",
						"start collaborating",
						"multi-user mode",
						"multiplayer mode",
						"collaboration mode",
						"collaborative mode",
						"collaborating mode",
						"online mode",
						"go online",
						"share canvas",
						"play with friends",
						"draw with friends",
						"draw together with friends",
						"draw together",
						"multiplayer",
						"multi-user",
						"collaborate",
						"collaboration",
						"collaborative",
						"collaborating",
					],
					action: ()=> {
						show_multi_user_setup_dialog(true);
					},
					description: "Starts a new multi-user session from the current document.",
				},
				{
					item: "New &Blank Session",
					speech_recognition: [
						"new blank session",
						"new empty session",
						"new fresh session",
						"new blank multi-user session",
						"new empty multi-user session",
						"new fresh multi-user session",
						"new blank multiplayer session",
						"new empty multiplayer session",
						"new fresh multiplayer session",
						"new multi-user session",
						"new multiplayer session",
						"new collaboration session",
						"new collaborative session",
						"start multi-user session",
						"start multiplayer session",
						"start collaboration session",
						"start collaborative session",
						"start multi-user with a new",
						"start multiplayer with a new",
						"start collaboration with a new",
						"start collaborating with a new",
						"start multi-user with a blank",
						"start multiplayer with a blank",
						"start collaboration with a blank",
						"start collaborating with a blank",
						"start multi-user with an empty",
						"start multiplayer with an empty",
						"start collaboration with an empty",
						"start collaborating with an empty",
						"start multi-user with new",
						"start multiplayer with new",
						"start collaboration with new",
						"start collaborating with new",
						"start multi-user with blank",
						"start multiplayer with blank",
						"start collaboration with blank",
						"start collaborating with blank",
						"start multi-user with empty",
						"start multiplayer with empty",
						"start collaboration with empty",
						"start collaborating with empty",
					],
					action: ()=> {
						show_multi_user_setup_dialog(false);
					},
					description: "Starts a new multi-user session from an empty document.",
				},
			]
		}*/
		{
			item: "&Themes",
			submenu: [
				{
					item: "&Arcader",
					action: ()=> {
						set_theme("arcader.css");
					},
					enabled: () => get_theme() != "arcader.css",
					description: "Makes Arcader Artist fit in with the rest of the site.",
				},
				{
					item: "Wings of the &Past",
					action: ()=> {
						set_theme("classic.css");
					},
					enabled: () => get_theme() != "classic.css",
					description: "Makes Arcader Artist look like it came from a bygone era.",
				},
				{
					item: "Wings of the &Night",
					action: ()=> {
						set_theme("dark.css");
					},
					enabled: () => get_theme() != "dark.css",
					description: "EMO MODE",
				},
				{
					item: "&HTML6",
					action: ()=> {
						set_theme("modern.css");
					},
					enabled: () => get_theme() != "modern.css",
					description: "JS Paint's gross modern theme.",
				},
				{
					item: "&Winter",
					action: ()=> {
						set_theme("winter.css");
					},
					enabled: () => get_theme() != "winter.css",
					description: "Makes Arcader Artist look festive for the holidays.",
				},
				{
					item: "&Occult",
					action: ()=> {
						set_theme("occult.css");
					},
					enabled: () => get_theme() != "occult.css",
					description: "Starts the ritual.",
				},
			]
		},
		/*{
			item: "&Eye Gaze Mode",
			speech_recognition: [
				"toggle eye gaze mode",
				// @TODO: enable/disable / enter/leave(/exit) / turn on/off / start/stop
			],
			checkbox: {
				toggle: ()=> {
					if (location.hash.match(/eye-gaze-mode/i)) {
						// @TODO: confirmation dialog that you could cancel with dwell clicking!
						// if (confirm("This will disable eye gaze mode.")) {
						change_url_param("eye-gaze-mode", false);
						// }
					} else {
						change_url_param("eye-gaze-mode", true);
					}
				},
				check: ()=> {
					return location.hash.match(/eye-gaze-mode/i);
				},
			},
			description: "Enlarges buttons and provides dwell clicking.",
		},
		{
			item: "&Speech Recognition",
			speech_recognition: [
				"toggle speech recognition", "toggle speech recognition mode",
				"disable speech recognition", "disable speech recognition mode", "turn off speech recognition", "turn off speech recognition mode", "leave speech recognition mode", "exit speech recognition mode",
			],
			checkbox: {
				toggle: ()=> {
					if (location.hash.match(/speech-recognition-mode/i)) {
						change_url_param("speech-recognition-mode", false);
					} else {
						change_url_param("speech-recognition-mode", true);
					}
				},
				check: ()=> {
					return window.speech_recognition_active;
				},
			},
			enabled: ()=> window.speech_recognition_available,
			description: "Controls the application with voice commands.",
		},*/
		{
			item: "&Vertical Color Box",
			speech_recognition: [
				"toggle vertical color box", "toggle vertical color box mode",
				"toggle vertical colors box", "toggle vertical colors box mode",
				"toggle vertical palette", "toggle vertical palette mode",
				"toggle horizontal color box", "toggle horizontal color box mode",
				"toggle horizontal colors box", "toggle horizontal colors box mode",
				"toggle horizontal palette", "toggle horizontal palette mode",
				// @TODO: "use a vertical/horizontal color box", "place palette on the left", "make palette tall/wide", etc.
			],
			checkbox: {
				toggle: ()=> {
					if (location.hash.match(/eye-gaze-mode/i)) {
						// @TODO: confirmation dialog that you could cancel with dwell clicking!
						// if (confirm("This will disable eye gaze mode.")) {
						// change_some_url_params({
						// 	"eye-gaze-mode": false,
						// 	"vertical-color-box-mode": false,
						// });
						// }
					} else if (location.hash.match(/vertical-color-box-mode/i)) {
						change_url_param("vertical-color-box-mode", false);
					} else {
						change_url_param("vertical-color-box-mode", true);
					}
				},
				check: ()=> {
					return location.hash.match(/vertical-color-box-mode|eye-gaze-mode/i);
				},
			},
			enabled: ()=> {
				return !location.hash.match(/eye-gaze-mode/i);
			},
			description: "Arranges the color box vertically.",
		},/*
		MENU_DIVIDER,
		{
			item: "Manage Storage",
			speech_recognition: [
				// This is a duplicate menu item (for easy access), so it doesn't need speech recognition data here.
			],
			action: ()=> { manage_storage(); },
			description: "Manages storage of previously created or opened pictures.",
		},*/
		MENU_DIVIDER,
		/*{
			item: "Project News",
			speech_recognition: [
				"project news", "news about the project", "news about this project",
				"app news", "news about the app", "news about this app",
				"application news", "news about the application", "news about this application",
				"what's new", "new features",
			],
			action: ()=> { show_news(); },
			description: "Shows news about JS Paint.",
		},*/
		{
			item: "JS Paint GitHub",
			speech_recognition: [
				"repo on github", "project on github", "show the source code", "show source code",
			],
			action: ()=> { window.open("https://github.com/1j01/jspaint"); },
			description: "Shows the project on GitHub.",
		}/*,
		{
			item: "Donate",
			speech_recognition: [
				"donate", "make a monetary contribution",
			],
			action: ()=> { window.open("https://www.paypal.me/IsaiahOdhner"); },
			description: "Supports the project.",
		},*/
	],
};

for (const [top_level_menu_key, menu] of Object.entries(menus)) {
	const top_level_menu_name = top_level_menu_key.replace(/&/, "");
	const add_literal_navigation_speech_recognition = (menu, ancestor_names)=> {
		for (const menu_item of menu) {
			if (menu_item !== MENU_DIVIDER) {
				const menu_item_name = menu_item.item.replace(/&|\.\.\.|\(|\)/g, "");
				// console.log(menu_item_name);
				let menu_item_matchers = [menu_item_name];
				if (menu_item_name.match(/\//)) {
					menu_item_matchers = [
						menu_item_name,
						menu_item_name.replace(/\//, " "),
						menu_item_name.replace(/\//, " and "),
						menu_item_name.replace(/\//, " or "),
						menu_item_name.replace(/\//, " slash "),
					];
				}
				menu_item_matchers = menu_item_matchers.map((menu_item_matcher)=> {
					return `${ancestor_names} ${menu_item_matcher}`;
				});
				menu_item.speech_recognition = (menu_item.speech_recognition || []).concat(menu_item_matchers);
				// console.log(menu_item_matchers, menu_item.speech_recognition);

				if (menu_item.submenu) {
					add_literal_navigation_speech_recognition(menu_item.submenu, `${ancestor_names} ${menu_item_name}`);
				}
			}
		}
	};
	add_literal_navigation_speech_recognition(menu, top_level_menu_name);
}

})();
