import React from 'react';

export default function HomePage() {
    return (

        <div className='flex items-center w-full pt-28 px-14 text-left'>
            <div className="-z-50 absolute inset-0 h-full w-full bg-transparent bg-[linear-gradient(to_right,#4f4f4f2e_1px,transparent_1px),linear-gradient(to_bottom,#4f4f4f2e_1px,transparent_1px)] bg-[size:50px_50px] [mask-image:radial-gradient(ellipse_100%_75%_at_100%_75%,#000_60%,transparent_100%)]"></div>
            <div className='flex flex-col w-fit gap-4'>
                <div className='z-0'>
                    <h1 className='text-5xl font-bold'>Welcome to the <span className=' px-4 rounded-tl-[0.9em] rounded-tr-[0.4em] rounded-bl-[0.4em] rounded-br-[0.9em] text-white bg-gradient-to-r  from-[#005bcb] to-[#1f87ff] whitespace-nowrap '>admin panel</span></h1>
                </div>
                <div>
                    <h2 className='text-2xl ml-6 mt-6'>This is a simple admin panel <br></br> for managing products and categories.</h2>
                </div>
                <div>
                    <p className='text-lg ml-6'>You can create, modify and delete products and categories</p>
                </div>
                <div className='flex w-full ml-12'>
                    <div className='flex mt-12 gap-4 overflow-hidden '>
                        <button className="bg-slate-800 py-1 px-4 rounded-full text-white border-2 border-slate-300/30 hover:bg-slate-900">
                            <a href='/products'>
                                <span className='text-lg'>Products</span>
                            </a>
                        </button>
                        <button className='bg-slate-800 py-1 px-4 rounded-full text-white border-2 border-slate-300/30 hover:bg-slate-900'>
                            <a href='/categories'>
                                <span className='text-lg'>Categories</span>
                            </a>
                        </button>
                    </div>
                </div>
            </div>
            <div className='absolute bottom-24 right-0'>
                <img src="../build/images/first.png" alt="first" width={800} />
            </div>

        </div >

    );
}

