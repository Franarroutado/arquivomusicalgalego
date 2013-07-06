# i18n Conventions based on https://github.com/alariva/yars/tree/master/app/lang

This is just a first approach, under revision.

## Objective of having a CONVENTION on i18n

  * maintain the lesser amount of files as possible
  * keep trans keys as short and readable as possible
  * minimize duplication
  * still identify the meaning of the wording in case the lang fetch fails
  * optimize file loading

# Application-Wide

Most short words will be used among all the app, such as buttons and nav items.

Keys will be likely to:

  * be needed all along the application, almost everywhere
  * be short strings in order to easily reference them
  * be kept in a single file for faster loading

        elementType.name

### Model Attributes

Many words will be used among all the app, most of them will be model-related.

Keys will be likely to:

  * be needed in different modules, always with the same meaning
  * refer different strings for the same item depending on the element type that holds it

        contextName/modelName.elementType.attributeName

### View-Specific Elements

Each view may have view-specific texts, like instructions, messages, alerts, errors which are only referenced from that single view.

Keys will be likely to:

  * be needed in a single view
  * refer to long texts

        contextName/viewName.elementType.codeName

# Diagram

                        +-----------------------------------------------+
                        |                                               |
     App-Wide           |     Common Buttons, Nav, Titles, Labels, etc  |
                        |                                               |
                        +-----------------------------------------------+
                        +-----------------+ +---------+---------+-------+
                        |                 | |         \         /       |
     Model              |       M 1       | |   M 2   /  M 2,3  \  M 3  |
                        |                 | |         \         /       |
                        +-----------------+ +---------+---------+-------+
                        +-------+ +-------+ +-------+ +-------+ +-------+
                        |       | |       | |       | |       | |       |
     View-Specific      |  V A  | |  V B  | |  V C  | |  V D  | |  V E  |
                        |       | |       | |       | |       | |       |
                        +-------+ +-------+ +-------+ +-------+ +-------+
     - - - - - - - - -      ^         ^         ^         ^         ^    
                        +-------+ +-------+ +-------+ +-------+ +-------+
                        |       | |       | |       | |       | |       |
     Views              |   A   | |   B   | |   C   | |   D   | |   E   |
                        |       | |       | |       | |       | |       |
                        +-------+ +-------+ +-------+ +-------+ +-------+