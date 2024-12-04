import React from "react";


const Navbar: React.FC = () => {
    return (
        <nav className="fixed w-full z-50 top-0 flex-none border-b border-[#e4e4e7] bg-white ">
            <div className="max-w-8xl mx-auto">
                <div className="flex py-4 px-4">
                    <div className="flex w-full items-center justify-between">
                        <div className="flex flex-row">
                            <div className="text-xl font-medium text-[#0072D3]">
                                <a href="/">
                                <img src="../build/images/logo.png" alt="logo" width={120} />
                                </a>
                            </div>
                        </div>
                        <div className="flex flex-row  items-center">
                        <div className="px-4 text-slate-700">
                                <a href="/products">Products</a>
                            </div>
                            <div className="px-4 text-slate-700">
                                <a href="/categories">Categories</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    );
};

export default Navbar;