import React from "react";



export default function NotFound() {
    return (
        <div className="flex flex-col items-center justify-center min-h-screen">
            <h1 className="text-6xl font-bold text-gray-800">404</h1>
            <p className="text-xl text-gray-600 mt-4">Page not found</p>
            <a
                href="/"
                className="mt-8 px-6 py-2 bg-[#229CFF] text-white rounded-full hover:bg-[#FF724F]"
            >
                Back to Home
            </a>
        </div>
    );
};