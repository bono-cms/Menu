$(function(){
    
    /**
	 * Redirects to current menu category
	 * 
	 * @return void
	 */
    function toCurrentCategory(){
        // We always have a category id
        var categoryId = $("[name='category_id']").val();

        // We must stay on the same category id
        window.location = $("form").data('category-url') + categoryId;
	}

	/**
	 * Redirect to item by its id
	 * 
	 * @param string id Item id
	 * @return void
	 */
	function toItem(id){
        window.location = $("form").data('item-url') + id;
	}

	/**
	 * Logs out and redirects back to login
	 * 
	 * @return void
	 */
	function toExit(){
        $("[data-button='logout']").click();
	}
	
	/**
	 * Redirect to menu module home page
	 * 
	 * @return void
	 */
	function toHome(){
		window.location = $("form").data('home-url');
	}
	
    
	function toAddingChild(category, parent){
        // Create URL
        var url = $("form").data('add-child-url');
        
        // Replace placeholders
        url = url.replace('{category}', category);
        url = url.replace('{parent}', parent);
        
        window.location = url;
	}
	
	/**
	 * Returns maximal allowed nested level depth
	 * 
	 * @return integer
	 */
	function getDepthLevel(){
		var $target = $("[name='max_depth']");
		
		if ($target.length > 0) {
			return parseInt($target.val());
		} else {
			// By default
			return 5;
		}
	}
	
	$('.chosen-select').chosen();
    
	var $contextMenu = $("#contextMenu");
    var $removeBtn = $("[data-button='remove']");
	var removalUrl = $removeBtn.data('url');

	$("body").on("contextmenu", "li.dd-item", function(e){
		e.preventDefault();

		$contextMenu.css({
            display: "block",
            left: $(this).position().left + 200,
			top: $(this).position().top
		});

		// Each li element has an id
		var id = $(this).data('id');

		$("[data-button='item-edit']").click(function(event){
			event.preventDefault();
			toItem(id);
		});

		// This event is attached only once, so there's no need to cancel it
		$("[data-button='add-child']").click(function(event){
			event.preventDefault();
			// Grab a category id
			var categoryId = $("[name='category_id']").val();

			toAddingChild(categoryId, id);
		});

        // Handle removal
        $removeBtn.data('id', id);

        if ($("[name='id']").val()) {
            var url = $removeBtn.data('base-removal-url') + id;
        } else {
            var url = removalUrl + id;
        }

        // Alter removal URL
        $removeBtn.data('url', url);

		return false;
	});
	
	$("body").click(function(){
		$contextMenu.hide();
	});
	
	$("[data-button='expand-all']").click(function(event){
		event.preventDefault();
		$('.dd').nestable('expandAll');
	});
	
	$("[data-button='collapse-all']").click(function(event){
		event.preventDefault();
		$('.dd').nestable('collapseAll');
	});
	
	// Add & Create new event listener
	$("[data-button='create-new']").off('click').click(function(event){
		event.preventDefault();
		$.ajax({
			url : $(this).data('url'),
			data : $("form").serialize(),
			success : function(response) {
				if ($.isNumeric(response)) {
					toCurrentCategory();
				} else {
					$.showErrors(response);
				}
			}
		});
	});
	
	// Add event listener
	$("[data-button='add']").off('click').click(function(event){
		event.preventDefault();
		$.ajax({
			url : $(this).data('url'),
			data : $("form").serialize(),
			success : function(response) {
				if ($.isNumeric(response)) {
					// On success response must represent a last id
					toItem(response);
				} else {
					$.showErrors(response);
				}
			}
		});
	});
	
	// Add & Exit event listener
	$("[data-button='create-exit']").click(function(event){
		event.preventDefault();
		$.ajax({
			url : $(this).data('url'),
			data : $("form").serialize(),
			success : function(response) {
				if ($.isNumeric(response)) {
					toExit();
				} else {
					$.showErrors(response);
				}
			}
		});
	});

	// Save event listener
    $("[data-button='save']").click(function(event) {
		event.preventDefault();
		$.ajax({
			url : $(this).data('url'),
			data : $("form").serialize(),
			success : function(response) {
				if ($.isNumeric(response)) {
					window.location.reload();
				} else {
					$.showErrors(response);
				}
			}
		});
	});
	
	// Save and Create event listener
	$("[data-button='save-create']").off('click').click(function(event){
		event.preventDefault();
		$.ajax({
			url : $(this).data('url'),
			data : $("form").serialize(),
			success : function(response) {
				if (response == "1") {
					toCurrentCategory();
				} else {
					$.showErrors(response);
				}
			}
		});
	});
	
	// Save and exit event listener
	$("[data-button='save-exit']").off('click').click(function(event){
		event.preventDefault();
		$.ajax({
			url : $(this).data('url'),
			data : $("form").serialize(),
			success : function(response) {
				if (response == "1") {
					toExit();
				} else {
					$.showErrors(response);
				}
			}
		});
	});

    var hasLink = Boolean($("[name='has_link']").val());
    
	if (!hasLink){
		$("#custom-link-row").addClass('hidden');
	} else {
		$("#custom-link-row").removeClass('hidden');
	}
	
	$("[name='web_page_id']").change(function(event) {
		var val = $(this).val();
		var $customLink = $("#custom-link-row");
		var $hasLink = $("[name='has_link']");

		if (val == "0") {
			$customLink.removeClass('hidden');
			$hasLink.val("1");

		} else {
			$customLink.addClass('hidden');
			$hasLink.val("0");
		}

		var $name = $("[name='name']");

		if (val != "0" && val != "#") {
			var text = $(this).find("option:selected").text();
			$name.val(text);
		}
		
		return false;
	});
	
	$('div.dd').nestable({
		group: 1,
        maxDepth: getDepthLevel()
	}).on('change', function(e){
		var list = e.length ? e : $(e.target);
		
		if (window.JSON) {
			var value = window.JSON.stringify(list.nestable('serialize'));
			
			$.ajax({
				url : $(this).data('url'),
				data : {
					"json_data" : value,
				},
				// Discard all previous AJAX listeners
				beforeSend : function(){},
				complete : function(){},
				success : function(response){
					// Don't do anything here for now, but log the response
					console.log(response);
				}
			});
		}
	});
});