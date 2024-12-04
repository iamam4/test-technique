import React from "react";


const Navbar: React.FC = () => {
    return (
        <nav className="fixed w-full z-50 top-0 flex-none border-b border-[#e4e4e7] bg-white ">
            <div className="max-w-8xl mx-auto">
                <div className="flex py-4 px-4">
                    <div className="flex w-full items-center justify-between">
                        <div className="flex flex-row items-center">
                            <div className="text-xl font-medium text-[#0072D3]">
                                <a href="/">E<span className="text-[#FF724F]">-</span>commerce</a>
                            </div>
                            <div className="px-4 text-slate-700">
                                <a href="/products">Products</a>
                            </div>
                            <div className="px-4 text-slate-700">
                                <a href="/categories">Categories</a>
                            </div>
                        </div>


                        <div className="flex flex-row">
                        <a href="/login">
                            <div className="px-4 py-1 bg-[#FF724F] rounded-full text-white font-semibold border-2 border-slate-300/30 hover:bg-[#ec6e4e] ">
                                <span>Login</span>
                            </div>
                        </a>
                        </div>
                    </div>
                </div>


            </div>
        </nav>
    );
};

export default Navbar;