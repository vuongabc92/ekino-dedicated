# V2 MODULES 
## Summary
The module is provided these embedded modules into Panels Templates Pages:

    1. SLIDER MODULE
    
    2. MODULE INTRO
    
    3. MODULE BANNER
    
    4. MODULE CROSS SELL
    
    5. MODULE CROSS CONTENT
    
    6. MODULE TEXT (1 and 2 COLUMNS)
    
    7. MODULE IMAGE & TEXT (card optional)
    
    8. MODULE QUOTE
    
    9. MODULE VIDEO
    
    10. MODULE PHOTO GALLERY
    
    11. MODULE CALL TO ACTION

## Requirements
V2 MODULES require this module to be enabled:
    - v2_mumm

## Configurations
    a. Structure content types for embedded modules:
        - /admin/structure/modules

    b. Content of embedded modules:
        - /admin/module-content



## Structure
    a. Hook
        1. hook_ctools_plugin_directory
            -> Create content types for embedded modules.
        2. hook_init
            -> Detect with admin role to add v2_mumm.css
        3. hook_menu
            -> Define menu link to manage content for V2 site.
        4. hook_form(v2_node_form)
            -> Render node form embedded modules.
    
    b. Schema
        - N/A
    

## TROUBLESHOOTING --

## FAQ

## CONTACT