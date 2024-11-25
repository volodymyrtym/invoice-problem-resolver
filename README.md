# Backend Architecture Overview

All described architecture and principles are related to the backend part of the product. The frontend or other
components, such as mobile applications, can be developed separately and connected via API, although all these parts are
stored in this repository, which serves as a monorepo.

## Project Goal

This project is an academic experiment aimed at implementing the best practices from various architectural approaches: *
*DDD (Domain-Driven Design)**, **Clean Architecture**, and **Screaming Architecture**. The primary goal is to develop a
balanced and flexible architecture that combines module isolation, clarity, and simplicity in development.

This project explores how different architectural approaches can be combined in real-world scenarios, striking a balance
between complexity and utility. It may also serve as an educational example for developers interested in modular
architecture, DDD, and SOLID principles.

A key focus of the project is **modular architecture**, which allows for:

- Easy scalability of the system.
- Functional isolation within independent modules.
- A smooth transition to microservices architecture.

---

## Core Principles

### 1. Modularity

- All modules are isolated and interact only through contracts.
- Each module is self-contained, simplifying:
    - Replacement or updates of individual modules.
    - Splitting the system into services with minimal changes to the codebase.
- **Core modules** (`DailyActivity`, `User`) are located in the same directory hierarchy as **support modules
  ** (`Authentication`, `Authorization`), with clearly defined responsibilities.

### 2. Flexibility

- A combination of **DDD**, **Clean Architecture**, and **Screaming Architecture** is used.
- Each module can implement its architecture depending on its purpose.

### 3. Simplicity

- Avoidance of excessive DTOs, redundant abstractions, or elements that overcomplicate development.
- The code is organized to avoid "treasure hunts" across directories.

---

## Implementation Details

### 1.1. Domain-Driven Design (DDD)

- Entities are built following DDD principles and have the following characteristics:
    - Encapsulate business logic relevant to their domain.
    - Support nested objects and can generate domain events.
    - Ensure immutability where necessary using Value Objects.
    - Contain only references to other entities as identifiers, avoiding direct dependencies through ORM or other
      persistence mechanisms.
    - Have meaningful method names that clearly reflect domain logic and ensure ease of use.
- **Core modules** define the main functionality, while **support modules** (`Authentication`, `Authorization`)
  complement them, with clear responsibility separation.

This design ensures a clear representation of the business domain model in the code, simplifying understanding and
maintenance.

### 1.2. Clean Architecture and SOLID Principles

#### Key Idea

Clean Architecture is used not as a canonical model but as a source of key principles, such as **Dependency Inversion**
and **SOLID**.

#### Implementation in the Project

- **Dependency Control:**
    - Modules depend only on contracts, ensuring flexibility and scalability.
    - External dependencies in entities and handlers are kept to a minimum.

#### Personal Perspective

In my view, **Clean Architecture and similar approaches (Onion, Hexagonal)** are primarily designed to ensure clear
separation of responsibilities and to decouple abstractions from details. They address the problem of mixing logic with
implementation details, but at the cost of added structural complexity.

In some modules, I use a simplified structure inspired by **Vertical Slice Architecture**. This approach retains
modularity without unnecessary complexity where it isn’t required. For example, **Screaming Architecture** is applied
only in core modules like `DailyActivity` and `User`, where `UseCase` is a fundamental concept. In support modules
like `Authorization` and `Authentication`, the absence of `UseCase` results in a simplified code organization that
matches their lower complexity and role in the overall system.

Thus, when I say I use Clean Architecture, I mean I adopt its core principles, including **SOLID** and especially *
*Dependency Inversion**, while adapting it to the needs and complexity of each module rather than striving for a pure
implementation.

### 1.3. Screaming Architecture

- All components related to `UseCase` are grouped in a single directory:
    - HTTP Controllers
    - Symfony Console Commands
    - Message Consumers

---

## Benefits of Modular Architecture

- **Functional Isolation:** Each module has clear boundaries of responsibility.
- **Ease of Maintenance and Extension:** Modules can be replaced, tested, or enhanced without affecting other parts of
  the system.
- **Transition to Microservices:** Modular isolation makes it easy to extract modules into separate services with
  minimal changes.
- **Team Collaboration:** Different modules can be developed and maintained by separate teams with minimal risk of
  conflicts.

---

## Conclusion

From my experience working on this project, building such an architecture requires careful planning and attention to
detail. The core principles of the project—modularity and control of inter-module coupling—are critically important.
Tight coupling between modules is far more detrimental than violating other principles within an individual module. This
is why maintaining module isolation and properly using contracts are at the heart of this project’s architecture.

Developing such an architecture also requires a certain level of team maturity, including:

- A deep understanding of modularity and isolation principles.
- A meticulous approach to code reviews and module design.
- Thoughtful delineation of responsibilities between modules.

This architecture provides a foundation for flexibility, scalability, and the ability to introduce changes to the system
while preserving simplicity and logical structure. Combining different architectural approaches such as Clean
Architecture, Screaming Architecture, and Vertical Slice Architecture demonstrates that their core principles can be
adapted to achieve a balance between complexity and flexibility when applied thoughtfully.

As a result, this project has proven to be not only a valuable learning experience but also a demonstration of how
well-organized architecture supports long-term maintainability and extensibility.

---

<details>
  <summary>🇺🇦 Переклад українською</summary>

## Мета проєкту

Цей проєкт є академічним експериментом, спрямованим на втілення найкращих практик із різних архітектурних підходів: *
*DDD (Domain-Driven Design)**, **Clean Architecture** та **Screaming Architecture**. Головна мета – розробити
збалансовану, гнучку архітектуру, яка поєднує ізоляцію модулів, зрозумілість та простоту розробки.

Цей проєкт дозволяє дослідити, як різні архітектурні підходи можуть поєднуватися у реальному світі, демонструючи баланс
між складністю та користю. Він також може стати навчальним прикладом для розробників, які цікавляться модульною
архітектурою, DDD та SOLID-принципами.

Один із ключових акцентів проєкту – **модульна архітектура**, яка дозволяє:

- Легко масштабувати систему.
- Ізолювати функціонал у незалежних модулях.
- Полегшити перехід до мікросервісної архітектури.

---

## Основні принципи

### 1. Модульність

- Всі модулі ізольовані один від одного і взаємодіють лише через контракти.
- Кожен модуль самодостатній, що спрощує:
    - Заміщення чи оновлення окремих модулів.
    - Розділення системи на сервіси без значних змін у кодовій базі.
- **Core-модулі** (`DailyActivity`, `User`) знаходяться в тій самій ієрархії директорій, що й
  support-модулі (`Authentication`, `Authorization`), з чітким розподілом відповідальностей.

### 2. Гнучкість

- Використовується суміш підходів **DDD**, **Clean Architecture** та **Screaming Architecture**.
- Кожен модуль може реалізовувати свою архітектуру, якщо це відповідає його завданням.

### 3. Простота

- Уникання створення надмірних DTO, зайвих слів чи елементів, які ускладнюють розробку.
- Код організований так, щоб уникнути "пошукового квесту" по директоріях.

---

## Особливості реалізації

### 1.1. Domain-Driven Design (DDD)

- Сутності (`Entity`) побудовані відповідно до принципів DDD і мають такі характеристики:
    - Інкапсулюють бізнес-логіку, пов’язану зі своєю доменною областю.
    - Підтримують вкладені об’єкти та можуть генерувати доменні події.
    - Забезпечують імутабельність у випадках, де це необхідно, через використання Value Object.
    - Містять лише посилання на ідентифікатори інших сутностей, без прямої залежності через ORM або інші механізми
      зберігання.
    - Мають осмислені назви методів, які чітко відображають доменну логіку та забезпечують зрозумілість використання.
- **Core-модулі** визначають основний функціонал, а support-модулі (`Authentication`, `Authorization`) доповнюють їх,
  чітко розділяючи відповідальності.

### 1.2. Clean Architecture та SOLID-принципи

#### Основна ідея

Clean Architecture використовується не як канонічна модель, а як джерело ключових принципів, таких як **Dependency
Inversion** та **SOLID**.

#### Реалізація в проєкті

- **Контроль залежностей:**
    - Модулі залежать лише від контрактів, що робить систему гнучкою та легко масштабованою.
    - У сутностях та хендлерах зовнішні залежності зведені до мінімуму.

#### Особиста думка

На мою думку, **Clean Architecture та подібні архітектурні підходи (Onion, Hexagonal)** створені насамперед для чіткого
розділення відповідальностей і відокремлення деталей від абстракцій. Вони вирішують проблему змішування логіки та
деталей реалізації, але за це доводиться платити ускладненням структури коду.

У деяких модулях я використовую спрощену структуру, що базується на підходах, подібних до **Vertical Slice Architecture
**. Це дозволяє зберігати розділення на модулі без зайвої складності там, де це не потрібно. Наприклад, **Screaming
Architecture** я застосовую тільки в core-модулях, таких як `DailyActivity` чи `User`, де є чітке поняття `UseCase`. У
support-модулях, таких як `Authorization` чи `Authentication`, відсутність `UseCase` призводить до спрощеної організації
коду, що відповідає їхній меншій складності та ролі в загальній системі.

Таким чином, коли я кажу, що використовую Clean Architecture, це означає, що я запозичую її основні принципи, зокрема *
*SOLID** і насамперед **Dependency Inversion**, а також адаптую її відповідно до потреб і складності кожного модуля, не
намагаючись реалізувати її в чистому вигляді.

### 1.3. Screaming Architecture

- Усі компоненти, пов’язані з використанням `UseCase`, зосереджені в одній директорії:
    - HTTP-контролери
    - Symfony Console Commands
    - Message Consumers

---

## Переваги модульного підходу

- **Ізоляція функціоналу:** кожен модуль має чіткі межі відповідальності.
- **Легкість у підтримці та розширенні:** модулі можна замінювати, тестувати або доповнювати без впливу на інші частини
  системи.
- **Перехід до мікросервісної архітектури:** ізоляція модулів забезпечує можливість легко виділяти їх у окремі сервіси з
  мінімальними змінами.
- **Командна робота:** різні модулі можуть розроблятися та підтримуватися різними командами, без значного ризику
  виникнення конфліктів.

---

## Висновок

З досвіду роботи над цим проєктом можу сказати, що створення такої архітектури вимагає ретельного планування та уваги до
деталей. Основні принципи, які лежать в основі проєкту, такі як модульність і контроль зв’язності між модулями, є
критично важливими. Зв’язність між модулями (tight coupling) є набагато більшим злом, ніж порушення будь-яких інших
принципів усередині кожного окремо взятого модуля. Саме тому дотримання ізоляції модулів і правильного використання
контрактів лежить в основі архітектури цього проєкту.

Робота над такою архітектурою також вимагає певного рівня зрілості команди, включаючи:

- Глибоке розуміння принципів модульності та ізоляції.
- Уважний підхід до code review і ретельного проектування.
- Обдумане розмежування відповідальностей між модулями.

Використання цієї архітектури створює основу для гнучкості, масштабованості та внесення змін у систему, зберігаючи при
цьому простоту та логічну структуру. Поєднання різних архітектурних підходів, таких як Clean Architecture, Screaming
Architecture і Vertical Slice Architecture, показало, що їхні ключові принципи можуть бути адаптовані для досягнення
балансу між складністю та гнучкістю, якщо їх правильно застосовувати.

Таким чином, цей проєкт став не лише корисним досвідом, але й демонстрацією того, як грамотно організована архітектура
сприяє довготривалій підтримці та легкому розширенню системи.

</details>

## DEV Prepare

1. run dev.sh
2. all project styles for backend already in .idea directory of this repo

## RUN

1. Run ```make rebuild```
2. Add to etc/hosts

```
   127.0.0.1 api.invoice-problem-resolver.loc
   127.0.0.1 invoice-problem-resolver.loc
   ```

3. Create user via console `make symfony console app:user:create`
