import React, { useState, useEffect } from "react";

function App() {
    const [tasks, setTasks] = useState([]);
    const [taskInput, setTaskInput] = useState("");

    // Fetch list of tasks from database on change
    useEffect(() => {
        fetchTasks();
        /*
        const dummyTasks = [
            { id: 1, task: "Dummy Task 1", status: "pending" },
            { id: 2, task: "Dummy Task 2", status: "completed" }
        ];
        setTasks(dummyTasks);
        */
    }, []);

    const fetchTasks = async () => {
        const response = await fetch("http://localhost:8000/tasks.php");
        const data = await response.json();
        /*
        const text = await response.text();
        console.log("Raw response:", text);
        const data = JSON.parse(text);
        console.log("Parsed data:", data);
        */
        setTasks(data);
    };

    // Create new task with POST request
    const addTask = async () => {
        // Check for empty input
        if (!taskInput.trim()) return;
        await fetch("http://localhost:8000/tasks.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ task: taskInput }),
        });
        setTaskInput("");
        fetchTasks();
    };

    // Update a task status to completed with PUT request
    const completeTask = async (id) => {
        await fetch("http://localhost:8000/tasks.php", {
            method: "PUT",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ id }),
        });
        fetchTasks();
    };

    // Delete an existing task with DELETE request
    const deleteTask = async (id) => {
        await fetch("http://localhost:8000/tasks.php", {
            method: "DELETE",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ id }),
        });
        fetchTasks();
    };

    return (
        <div className="container">
            <h2>To-Do List</h2>
            <div className="task-input">
                <input
                    type="text"
                    placeholder="Enter a task..."
                    value={taskInput}
                    onChange={(e) => setTaskInput(e.target.value)}
                />
                <button onClick={addTask}>Add</button>
            </div>
            <ul>
                {tasks.map(task => (
                    <li key={task.id} className={task.status === "completed" ? "completed" : ""}>
                        {task.task}
                        <div className="buttons">
                            <button onClick={() => completeTask(task.id)}>✓</button>
                            <button onClick={() => deleteTask(task.id)}>✖</button>
                        </div>
                    </li>
                ))}
            </ul>
        </div>
    );
}

export default App;
