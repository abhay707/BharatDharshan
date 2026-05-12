# Graph Report - app  (2026-05-05)

## Corpus Check
- Corpus is ~1,769 words - fits in a single context window. You may not need a graph.

## Summary
- 95 nodes · 83 edges · 15 communities (6 shown, 9 thin omitted)
- Extraction: 82% EXTRACTED · 18% INFERRED · 0% AMBIGUOUS · INFERRED: 15 edges (avg confidence: 0.8)
- Token cost: 0 input · 0 output

## Community Hubs (Navigation)
- [[_COMMUNITY_Food Admin Resource|Food Admin Resource]]
- [[_COMMUNITY_State Admin Resource|State Admin Resource]]
- [[_COMMUNITY_Tradition Admin Resource|Tradition Admin Resource]]
- [[_COMMUNITY_Food CRUD Pages|Food CRUD Pages]]
- [[_COMMUNITY_State CRUD Pages|State CRUD Pages]]
- [[_COMMUNITY_Tradition CRUD Pages|Tradition CRUD Pages]]
- [[_COMMUNITY_State Model & Relations|State Model & Relations]]
- [[_COMMUNITY_Public API Controller|Public API Controller]]
- [[_COMMUNITY_App Service Provider|App Service Provider]]
- [[_COMMUNITY_User & Auth Model|User & Auth Model]]
- [[_COMMUNITY_StateFood Model|StateFood Model]]
- [[_COMMUNITY_Filament Panel Config|Filament Panel Config]]
- [[_COMMUNITY_StateCulture Model|StateCulture Model]]
- [[_COMMUNITY_StateTradition Model|StateTradition Model]]
- [[_COMMUNITY_Base Controller|Base Controller]]

## God Nodes (most connected - your core abstractions)
1. `State` - 6 edges
2. `StateFoodResource` - 5 edges
3. `StateResource` - 5 edges
4. `StateTraditionResource` - 5 edges
5. `StateController` - 4 edges
6. `AppServiceProvider` - 3 edges
7. `User` - 3 edges
8. `StateFood` - 3 edges
9. `StateFoodTable` - 3 edges
10. `StateFoodForm` - 3 edges

## Surprising Connections (you probably didn't know these)
- None detected - all connections are within the same source files.

## Communities (15 total, 9 thin omitted)

### Community 0 - "Food Admin Resource"
Cohesion: 0.18
Nodes (3): StateFoodForm, StateFoodResource, StateFoodTable

### Community 1 - "State Admin Resource"
Cohesion: 0.18
Nodes (3): StateForm, StateResource, StatesTable

### Community 2 - "Tradition Admin Resource"
Cohesion: 0.18
Nodes (3): StateTraditionForm, StateTraditionResource, StateTraditionsTable

### Community 3 - "Food CRUD Pages"
Cohesion: 0.22
Nodes (3): CreateStateFood, EditStateFood, ListStateFood

### Community 4 - "State CRUD Pages"
Cohesion: 0.22
Nodes (3): CreateState, EditState, ListStates

### Community 5 - "Tradition CRUD Pages"
Cohesion: 0.22
Nodes (3): CreateStateTradition, EditStateTradition, ListStateTraditions

## Knowledge Gaps
- **1 isolated node(s):** `Controller`
  These have ≤1 connection - possible missing edges or undocumented components.
- **9 thin communities (<3 nodes) omitted from report** — run `graphify query` to explore isolated nodes.

## Suggested Questions
_Questions this graph is uniquely positioned to answer:_

- **Why does `StateFoodResource` connect `Food Admin Resource` to `Food CRUD Pages`?**
  _High betweenness centrality (0.028) - this node is a cross-community bridge._
- **Why does `StateResource` connect `State Admin Resource` to `State CRUD Pages`?**
  _High betweenness centrality (0.028) - this node is a cross-community bridge._
- **Why does `StateTraditionResource` connect `Tradition Admin Resource` to `Tradition CRUD Pages`?**
  _High betweenness centrality (0.028) - this node is a cross-community bridge._
- **What connects `Controller` to the rest of the system?**
  _1 weakly-connected nodes found - possible documentation gaps or missing edges._